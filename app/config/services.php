<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/03/2025, 21:06
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

use App\Controller\Admin\DashboardController;
use App\Controller\Admin\Setting\SettingCrudController;
use App\Controller\Admin\Setting\SettingDomainCrudController;
use App\Repository\Setting\SettingDomainRepository;
use App\Repository\Setting\SettingRepository;
use App\Repository\Setting\SettingUserRepository;
use App\Repository\User\UserRepository;

return static function (ContainerConfigurator $container) {
	// @formatter:off
	$container
		->services()
			->set(SettingRepository::class)->public()->autowire()->autoconfigure()
			->set(SettingDomainRepository::class)->public()->autowire()->autoconfigure()
			->set(SettingUserRepository::class)->public()->autowire()->autoconfigure()
			->set(UserRepository::class)->public()->autowire()->autoconfigure()

			// Admin controller
			->set(DashboardController::class)->public()->autowire()->autoconfigure()
			->set(SettingCrudController::class)->public()->autowire()->autoconfigure()
			->set(SettingDomainCrudController::class)->public()->autowire()->autoconfigure()
	;
	// @formatter:on
};
