<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 06/01/2025, 12:15
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    security.php
 * @date    02/01/2025
 * @time    20:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
	$container->extension('security', [
		'firewalls'      => [
			'main' => [],
		],
		'role_hierarchy' => [
			'ROLE_ADMIN'       => 'ROLE_USER',
			'ROLE_SUPER_ADMIN' => ['ROLE_ADMIN', 'ROLE_ALLOWED_TO_SWITCH'],
		],
	]);
};
