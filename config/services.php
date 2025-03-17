<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 18:04
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    services.php
 * @date    02/01/2025
 * @time    20:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Idm\Bundle\Settings\EntityListener\SettingListener;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Marshaller\SodiumMarshaller;

return function (ContainerConfigurator $container) {
	// @formatter:off
	$container->services()
		->set('idm_settings.service.cache_adapter.settings', FilesystemAdapter::class)
			->private()
			->args(['', '0', '%kernel.cache_dir%/pools/settings', service('cache.default_marshaller')])

		->set('idm_settings.service.cache_adapter.settings.encrypt', FilesystemAdapter::class)
			->private()
			->args(['', '0', '%kernel.cache_dir%/pools/settings', service('idm_settings.cache.sodium_marshaller')])

		->set('idm_settings.cache.sodium_marshaller', SodiumMarshaller::class)
			->arg('$decryptionKeys', param('idm_settings.parameter.cache_keypair'))
			->arg('$marshaller', service('cache.default_marshaller'))
			->private()

		->set(SettingListener::class)
			->arg('$cache', service('idm_settings.cache'))
	;
	// @formatter::on
};
