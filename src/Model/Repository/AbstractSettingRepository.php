<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/03/2025, 23:09
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    AbstractSettingRepository.php
 * @date    14/03/2025
 * @time    21:52
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Model\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Idm\Bundle\Settings\Enums\SettingsKeysEnum;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;
use Idm\Bundle\Settings\Model\Entity\AbstractSettingDomain;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @extends ServiceEntityRepository<AbstractSetting>
 */
abstract class AbstractSettingRepository extends ServiceEntityRepository
	implements SettingsCacheInterface, SettingsCacheEncryptInterface
{
	/** By default, not use encrypted cache */
	protected bool $encryptCache = false;

	private CacheItemPoolInterface&TagAwareCacheInterface $cacheEncrypt;
	private CacheItemPoolInterface&TagAwareCacheInterface $cache;

	/**
	 * @throws InvalidArgumentException
	 */
	public function getSettingObject (string $settingName, ?bool $encrypted = null): ?AbstractSetting
	{
		$encrypted = $encrypted ?? $this->encryptCache;

		$key = SettingsKeysEnum::slug($this->getEntityName()::ENTITY_NAME, $settingName);

		return $this->getCache($encrypted)->get($key, function (ItemInterface $item) use ($key) {
			$entity = $this->findOneBy(['slug' => $key]);

			if (null === $entity) {
				// If not found, it is cached for 30 seconds.
				$item->expiresAfter(30);

				return null;
			}

			$item->tag([SettingsKeysEnum::SETTING->value, $entity->getSlug()]);

			return $entity;
		});
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function getSetting (string $settingName, ?bool $encrypted = null): null|string|int|float|bool
	{
		return $this->getSettingObject($settingName, $encrypted)?->getFormatedValue();
	}

	/**
	 * Get a list of settings for a given domain.
	 *
	 * @return ArrayCollection<AbstractSetting>
	 * @throws InvalidArgumentException
	 */
	public function getSettingsObjectsByDomain (string $domainName, ?bool $encrypted = null): ArrayCollection
	{
		$encrypted = $encrypted ?? $this->encryptCache;
		$key = SettingsKeysEnum::slug(SettingsKeysEnum::COLLECTION_SETTINGS_BY_DOMAIN->value, $domainName);

		return $this->getCache($encrypted)->get($key, function (ItemInterface $item) use ($key, $domainName) {
			/** @var AbstractSettingDomainRepository $rep */
			$rep = $this->getEntityManager()->getRepository(AbstractSettingDomain::class);
			$domain = $rep->getDomainObject($domainName);

			if (null === $domain) {
				return new ArrayCollection();
			}

			$item->tag([SettingsKeysEnum::COLLECTION_SETTINGS_BY_DOMAIN->value, $key, $domain->getSlug()]);

			$entities = $this->findBy(['domain' => (string)$domain->getId()]);

			if ([] === $entities) {
				// Si no se encuentra se cachea 30 segundos
				$item->expiresAfter(30);

				return new ArrayCollection();
			}

			return new ArrayCollection($entities);
		});
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function getSettingsOfEntityById (string|Uuid $id, ?bool $encrypted = null): ArrayCollection
	{
		$encrypted = $encrypted ?? $this->encryptCache;
		$key = SettingsKeysEnum::COLLECTION_DOMAINS . '';

		return $this->getCache($encrypted)->get($key, function (ItemInterface $item) {});
	}

	public function getCache (bool $encrypted = false): CacheItemPoolInterface&TagAwareCacheInterface
	{
		return $encrypted ? $this->cacheEncrypt : $this->cache;
	}

	public function setCache (CacheItemPoolInterface&TagAwareCacheInterface $cache): self
	{
		$this->cache = $cache;

		return $this;
	}

	public function setCacheEncrypt (CacheItemPoolInterface&TagAwareCacheInterface $cacheEncrypt): self
	{
		$this->cacheEncrypt = $cacheEncrypt;

		return $this;
	}
}
