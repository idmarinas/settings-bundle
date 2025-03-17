<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 16/03/2025, 23:23
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

use App\Entity\User\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

return static function (ContainerConfigurator $container) {
	$container->extension('security', [
		'providers'        => [
			'idm_user_provider' => [
				'entity' => [
					'class'    => User::class,
					'property' => 'email',
				],
			],
		],
		'firewalls'        => [
			'main' => [
				'logout'     => [
					'path' => '/logout',
				],
				'provider'   => 'idm_user_provider',
				'form_login' => [
					'login_path'          => 'idm_user_login_web',
					'check_path'          => 'idm_user_login_web',
					'enable_csrf'         => true,
					'form_only'           => true,
					'default_target_path' => 'idm_user_profile_index',
				],
			],
		],
		'password_hashers' => [
			PasswordAuthenticatedUserInterface::class => [
				'algorithm'   => 'auto',
				'cost'        => 4,
				'time_cost'   => 3,
				'memory_cost' => 10,
			],
		],
		'role_hierarchy'   => [
			'ROLE_ADMIN'       => 'ROLE_USER',
			'ROLE_SUPER_ADMIN' => ['ROLE_ADMIN', 'ROLE_ALLOWED_TO_SWITCH'],
		],
	]);
};
