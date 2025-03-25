<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/03/2025, 20:02
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    EncryptCacheAndCacheTrait.php
 * @date    21/03/2025
 * @time    21:29
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Traits\Repository;

use Idm\Bundle\Settings\Interfaces\Entity\UseEncryptCacheInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

trait EncryptCacheAndCacheTrait
{
	private CacheItemPoolInterface&TagAwareCacheInterface $cacheEncrypt;

	private CacheItemPoolInterface&TagAwareCacheInterface $cache;

	public function getCache (?bool $encrypted = null): CacheItemPoolInterface&TagAwareCacheInterface
	{
		$encrypted ??= is_subclass_of($this->getEntityName(), UseEncryptCacheInterface::class);

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
