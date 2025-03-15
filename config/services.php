<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 15/03/2025, 11:58
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

use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Marshaller\SodiumMarshaller;

return function (ContainerConfigurator $container) {
	// @formatter:off
	$container->services()
		->set('idm_settings.service.cache_adapter.settings', FilesystemAdapter::class)
			->private()
			->arg('$directory', '%kernel.cache_dir%/pools/settings')
			->arg('$marshaller', service('cache.default_marshaller'))
		->alias(SettingsCacheInterface::class, 'idm_settings.service.cache_adapter.settings')
			->public()

		->set('idm_settings.service.cache_adapter.settings.encrypt', FilesystemAdapter::class)
			->private()
			->arg('$directory', '%kernel.cache_dir%/pools/settings')
			->arg('$marshaller', service('idm_settings.cache.sodium_marshaller'))
		->alias(SettingsCacheEncryptInterface::class, 'idm_settings.service.cache_adapter.settings.encrypt')
			->public()

		->set('idm_settings.cache.sodium_marshaller', SodiumMarshaller::class)
			->arg('$decryptionKeys', param('idm_settings.parameter.cache_keypair'))
			->arg('$marshaller', service('cache.default_marshaller'))
			->private()
	;
	// @formatter::on
};
