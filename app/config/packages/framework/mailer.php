<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/03/2025, 23:47
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    mailer.php
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
	$container->extension('framework', [
		'mailer' => [
			'dsn'      => $_ENV['MAILER_DSN'] ?? 'null://null',
			'envelope' => [
				'sender' => 'idm_bundle@test.bundle',
			],
			'headers'  => [
				'From' => 'IDMarinas Settings Bundle <idm_bundle@test.bundle>',
			],
		],
	]);
};
