<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 21:55
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
use Idm\Bundle\Settings\Exception\RequiredFieldMissingException;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheInterface;
use Idm\Bundle\Settings\Interfaces\Entity\SettingsWithEntityInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;
use Idm\Bundle\Settings\Model\Entity\AbstractSettingDomain;
use Idm\Bundle\Settings\Traits\Repository\EncryptCacheAndCacheTrait;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<AbstractSetting>
 */
abstract class AbstractSettingRepository extends ServiceEntityRepository
	implements SettingsCacheInterface, SettingsCacheEncryptInterface
{
	use EncryptCacheAndCacheTrait;

	/**
	 * @throws InvalidArgumentException
	 */
	public function getSettingObject (string $settingName, ?bool $encrypted = null): ?AbstractSetting
	{
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
		$key = SettingsKeysEnum::slug(SettingsKeysEnum::COLLECTION_SETTINGS_BY_DOMAIN->value, $domainName);

		return $this->getCache($encrypted)->get($key, function (ItemInterface $item) use ($key, $domainName) {
			/** @var AbstractSettingDomainRepository $rep */
			$rep = $this->getEntityManager()->getRepository(AbstractSettingDomain::class);
			$domain = $rep->getDomainObject($domainName);

			if (null === $domain) {
				return new ArrayCollection();
			}

			$item->tag([SettingsKeysEnum::COLLECTION_SETTINGS_BY_DOMAIN->value, $key, $domain->getSlug()]);

			$entities = $this->findBy(['domain' => $domain->getId()]);

			if ([] === $entities) {
				// If not found, it is cached for 30 seconds.
				$item->expiresAfter(30);

				return new ArrayCollection();
			}

			return new ArrayCollection($entities);
		});
	}

	/**
	 * Get settings of the Entity ID
	 *
	 * @return ArrayCollection<AbstractSetting>
	 * @throws InvalidArgumentException
	 * @throws RequiredFieldMissingException
	 */
	public function getSettingsOfEntityById (string|Uuid $id, ?bool $encrypted = null): ArrayCollection
	{
		$this->compatibilitySettingsWithEntity(__METHOD__);

		$slug = SettingsKeysEnum::slug($this->getEntityName()::ENTITY_NAME, $id);
		$key = SettingsKeysEnum::COLLECTION_SETTINGS_BY_ENTITY_ID->value . '.' . $slug;

		return $this->getCache($encrypted)->get($key, function (ItemInterface $item) use ($key, $id, $slug) {
			$entities = $this->findBy(['entity' => $id]);

			if ([] === $entities) {
				// If not found, it is cached for 30 seconds.
				$item->expiresAfter(30);

				return new ArrayCollection();
			}

			$item->tag([SettingsKeysEnum::COLLECTION_SETTINGS_BY_ENTITY_ID->value, $key, $slug]);

			return new ArrayCollection($entities);
		});
	}

	/**
	 * @throws RequiredFieldMissingException
	 * @throws InvalidArgumentException
	 */
	public function getSettingsOfEntityByIdAndDomain (string|Uuid $id, string $domainName, ?bool $encrypted = null):
	ArrayCollection {
		$this->compatibilitySettingsWithEntity(__METHOD__);

		$slug = SettingsKeysEnum::slug($this->getEntityName()::ENTITY_NAME, $domainName . '.' . $id);
		$key = SettingsKeysEnum::COLLECTION_SETTINGS_BY_ENTITY_ID_AND_DOMAIN->value . '.' . $slug;

		return $this->getCache($encrypted)->get($key, function (ItemInterface $item) use ($key, $domainName, $id, $slug) {
			/** @var AbstractSettingDomainRepository $rep */
			$rep = $this->getEntityManager()->getRepository(AbstractSettingDomain::class);
			$domain = $rep->getDomainObject($domainName);

			$entities = $this->findBy(['entity' => $id, 'domain' => $domain]);

			if ([] === $entities) {
				// If not found, it is cached for 30 seconds.
				$item->expiresAfter(30);

				return new ArrayCollection();
			}

			$domainSlug = $domain->getSlug();
			$item->tag([SettingsKeysEnum::COLLECTION_SETTINGS_BY_ENTITY_ID_AND_DOMAIN->value, $key, $slug, $domainSlug]);

			return new ArrayCollection($entities);
		});
	}

	/**
	 * @throws RequiredFieldMissingException
	 */
	private function compatibilitySettingsWithEntity (string $method): void
	{
		if (!is_subclass_of($this->getEntityName(), SettingsWithEntityInterface::class)) {
			throw new RequiredFieldMissingException(
				sprintf(
					'The method "%s" requires that the entity "%s" implements the interface "%s".',
					$method,
					$this->getEntityName(),
					SettingsWithEntityInterface::class
				)
			);
		}
	}
}
