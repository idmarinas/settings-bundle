<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 21:45
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingListener.php
 * @date    17/03/2025
 * @time    17:47
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
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsEntityListener(event: Events::postPersist, lazy: true)]
#[AsEntityListener(event: Events::postUpdate, lazy: true)]
#[AsEntityListener(event: Events::postRemove, lazy: true)]
readonly class SettingListener
{
	public function __construct (
		private CacheItemPoolInterface&TagAwareCacheInterface $cache,
		private CacheItemPoolInterface&TagAwareCacheInterface $cacheEncrypt
	) {}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postPersist (AbstractSetting $setting): void
	{
		$this->getCache($setting::class)->get($setting->getSlug(), function (ItemInterface $item) use ($setting) {
			$item->tag([SettingsKeysEnum::SETTING->value, $setting->getSlug(), $setting->getDomain()->getSlug()]);

			return $setting;
		});
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postUpdate (AbstractSetting $setting): void
	{
		$this->getCache($setting::class)->invalidateTags([$setting->getSlug()]);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postRemove (AbstractSetting $setting): void
	{
		$this->getCache($setting::class)->invalidateTags([$setting->getSlug()]);
		$this->getCache($setting::class)->delete($setting->getSlug());
	}

	private function getCache (string $class): CacheItemPoolInterface&TagAwareCacheInterface
	{
		return is_subclass_of($class, UseEncryptCacheInterface::class) ? $this->cacheEncrypt : $this->cache;
	}
}
