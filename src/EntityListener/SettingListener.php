<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 21:54
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
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;
use Psr\Cache\CacheException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\CacheItem;

#[AsEntityListener(event: Events::postPersist, lazy: true, entity: AbstractSetting::class)]
#[AsEntityListener(event: Events::postUpdate, lazy: true, entity: AbstractSetting::class)]
#[AsEntityListener(event: Events::postRemove, lazy: true, entity: AbstractSetting::class)]
readonly class SettingListener
{
	public function __construct (private CacheItemPoolInterface&SettingsCacheInterface $cache) {}

	/**
	 * @throws InvalidArgumentException
	 * @throws CacheException
	 */
	public function postPersist (AbstractSetting $setting): void
	{
		$item = new CacheItem();
		$item->set($setting)->tag([$setting->getCacheKey(), $setting->getDomain()->getCacheKey()]);

		$this->cache->save($item);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postUpdate (AbstractSetting $setting): void
	{
		$this->cache->invalidateTags([$setting->getCacheKey(), $setting->getDomain()->getCacheKey()]);
		$this->cache->delete($setting->getCacheKey());
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postRemove (AbstractSetting $setting): void
	{
		$this->cache->invalidateTags([$setting->getCacheKey(), $setting->getDomain()->getCacheKey()]);
		$this->cache->delete($setting->getCacheKey());
	}
}
