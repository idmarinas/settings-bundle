<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/03/2025, 22:52
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    fixtures.php
 * @date    14/03/2025
 * @time    21:52
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
	// @formatter:off
	$container
		->services()
			->load('DataFixtures\\', dirname(__DIR__, 2) . '/fixtures')
			->public()
			->autowire()
			->autoconfigure()
	;
	// @formatter:on
};
