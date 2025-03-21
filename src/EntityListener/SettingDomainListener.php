<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 21:43
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingDomainListener.php
 * @date    18/03/2025
 * @time    21:53
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\EntityListener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Idm\Bundle\Settings\Enums\SettingsKeysEnum;
use Idm\Bundle\Settings\Interfaces\Entity\UseEncryptCacheInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSettingDomain;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsEntityListener(event: Events::postPersist, lazy: true)]
#[AsEntityListener(event: Events::postUpdate, lazy: true)]
#[AsEntityListener(event: Events::postRemove, lazy: true)]
readonly class SettingDomainListener
{
	public function __construct (
		private CacheItemPoolInterface&TagAwareCacheInterface $cache,
		private CacheItemPoolInterface&TagAwareCacheInterface $cacheEncrypt
	) {}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postPersist (AbstractSettingDomain $domain): void
	{
		$this->getCache($domain::class)->get(
			$domain->getSlug(),
			function (ItemInterface $item) use ($domain) {
				$item->tag([SettingsKeysEnum::DOMAIN->value, $domain->getSlug()]);

				return $domain;
			}
		);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postUpdate (AbstractSettingDomain $domain): void
	{
		$this->getCache($domain::class)->invalidateTags([$domain->getSlug()]);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postRemove (AbstractSettingDomain $domain): void
	{
		$this->getCache($domain::class)->invalidateTags([$domain->getSlug()]);
		$this->getCache($domain::class)->delete($domain->getSlug());
	}

	private function getCache (string $class): CacheItemPoolInterface&TagAwareCacheInterface
	{
		return is_subclass_of($class, UseEncryptCacheInterface::class) ? $this->cacheEncrypt : $this->cache;
	}
}
