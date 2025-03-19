<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/03/2025, 21:18
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
use Idm\Bundle\Settings\Enums\SettingsCacheKeysEnum;
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
	public function __construct (private CacheItemPoolInterface&TagAwareCacheInterface $cache) {}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postPersist (AbstractSettingDomain $domain): void
	{
		$item = $this->cache->get($domain->getSlug(), function (ItemInterface $item) use ($domain) {
			return $item
				->set($domain)
				->tag([SettingsCacheKeysEnum::DOMAIN_ITEM->value, $domain->getSlug()])
			;
		});

		$this->cache->save($item);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postUpdate (AbstractSettingDomain $domain): void
	{
		$this->cache->invalidateTags([SettingsCacheKeysEnum::DOMAIN_ITEM->value, $domain->getSlug()]);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function postRemove (AbstractSettingDomain $domain): void
	{
		$this->cache->invalidateTags([SettingsCacheKeysEnum::DOMAIN_ITEM->value, $domain->getSlug()]);
		$this->cache->delete($domain->getSlug());
	}
}
