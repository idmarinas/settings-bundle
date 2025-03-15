<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 15/03/2025, 11:57
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    cache.php
 * @date    02/01/2025
 * @time    23:07
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config): void {
	// @formatter:off
	$config->cache()
		->pool('idm_settings.cache')
			->adapters(['idm_settings.service.cache_adapter.settings'])
			->tags('settings')
		->pool('idm_settings.encrypt.cache')
			->adapters(['idm_settings.service.cache_adapter.settings.encrypt'])
			->tags(['settings', 'encrypt'])
	;
};
