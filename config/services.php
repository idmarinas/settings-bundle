<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 03/01/2025, 24:11
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

use Idm\Bundle\Settings\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Cache\SettingsCacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Marshaller\SodiumMarshaller;

return function (ContainerConfigurator $container) {
	// @formatter:off
	$container->services()
		->set('idm_settings.service.cache.adapter.settings', FilesystemAdapter::class)
			->private()
			->args(['', '0', param('kernel.cache_dir').'/pools/settings', service('cache.default_marshaller')])
		->alias(SettingsCacheInterface::class, 'idm_settings.service.cache.adapter.settings')
			->public()

		->set('idm_settings.service.cache.adapter.settings.encrypt', FilesystemAdapter::class)
			->private()
			->args(['', '0', param('kernel.cache_dir').'/pools/settings_encrypt', service('idm_settings.cache.sodium_marshaller')])
		->alias(SettingsCacheEncryptInterface::class, 'idm_settings.service.cache.adapter.settings.encrypt')
			->public()

		->set('idm_settings.cache.sodium_marshaller', SodiumMarshaller::class)
			->args([[param('cache_decryption_key')], service('cache.default_marshaller')])
	;
	// @formatter::on
};
