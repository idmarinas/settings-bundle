<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/03/2025, 23:09
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
	public function __construct (private CacheItemPoolInterface&TagAwareCacheInterface $cache) {}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postPersist (AbstractSetting $setting): void
	{
		$item = $this->cache->get($setting->getSlug(), function (ItemInterface $item) use ($setting) {
			return $item
				->set($setting)
				->tag([SettingsKeysEnum::SETTING->value, $setting->getSlug(), $setting->getDomain()->getSlug()])
			;
		});

		$this->cache->save($item);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postUpdate (AbstractSetting $setting): void
	{
		$this->cache->invalidateTags([$setting->getSlug()]);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postRemove (AbstractSetting $setting): void
	{
		$this->cache->invalidateTags([$setting->getSlug()]);
		$this->cache->delete($setting->getSlug());
	}
}
