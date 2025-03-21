<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 15:30
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    AbstractSettingDomainRepository.php
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
use Idm\Bundle\Settings\Enums\SettingsKeysEnum;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSettingDomain;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @extends ServiceEntityRepository<AbstractSettingDomain>
 */
abstract class AbstractSettingDomainRepository extends ServiceEntityRepository
	implements SettingsCacheInterface, SettingsCacheEncryptInterface
{
	/** By default, not use encrypted cache */
	protected bool $encryptCache = false;

	private CacheItemPoolInterface&TagAwareCacheInterface $cacheEncrypt;
	private CacheItemPoolInterface&TagAwareCacheInterface $cache;

	/**
	 * @throws InvalidArgumentException
	 */
	public function getDomainObject (string $domainName, ?bool $encrypted = null): ?AbstractSettingDomain
	{
		$key = SettingsKeysEnum::slug('domain', $domainName);

		return $this->getCache($encrypted)->get($key, function (ItemInterface $item) use ($key) {
			$entity = $this->findOneBy(['slug' => $key]);

			if (null === $entity) {
				// If not found, it is cached for 30 seconds.
				$item->expiresAfter(30);

				return null;
			}

			$item->tag([SettingsKeysEnum::DOMAIN->value, $entity->getSlug()]);

			return $entity;
		});
	}

	public function getCache (?bool $encrypted = null): CacheItemPoolInterface&TagAwareCacheInterface
	{
		$encrypted = $encrypted ?? $this->encryptCache;

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
