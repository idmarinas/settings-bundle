<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/03/2025, 17:35
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingsCacheEncryptInterface.php
 * @date    02/01/2025
 * @time    23:14
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Interfaces\Cache;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

interface SettingsCacheEncryptInterface
{
	public function setCacheEncrypt (CacheItemPoolInterface&TagAwareCacheInterface $cacheEncrypt): self;
}
