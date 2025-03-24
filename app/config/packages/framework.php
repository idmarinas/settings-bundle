<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/03/2025, 21:14
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    framework.php
 * @date    02/01/2025
 * @time    20:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config) {
	$config
		->secret('test')
		->test(true)
		->httpMethodOverride(false)
		->handleAllThrowables(true)
	;
	$config->form()->enabled(true);
	$config->propertyAccess()->enabled(true);
	$config->phpErrors()->log(true);
	$config->serializer()->enabled(true);
	$config->assets()->enabled(true);
};
