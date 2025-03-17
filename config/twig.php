<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 16:14
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    twig.php
 * @date    15/03/2025
 * @time    11:43
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

use Idm\Bundle\Settings\Twig\Extension\SettingsExtension;
use Idm\Bundle\Settings\Twig\Runtime\SettingsRuntime;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
	// @formatter:off
	$container->services()
		->set('.idm_settings.twig.settings_extension', SettingsExtension::class)
			->tag('twig.extension')

		->set('.idm_settings.twig.settings_runtime', SettingsRuntime::class)
			->tag('twig.runtime')
	;
	// @formatter::on
};
