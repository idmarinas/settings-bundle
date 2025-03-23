<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/03/2025, 19:58
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    routes.php
 * @date    23/03/2025
 * @time    19:58
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

use App\Controller\Admin\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminRouteLoader;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
	// @formatter:off
	$routes
		->import(DashboardController::class, AdminRouteLoader::ROUTE_LOADER_TYPE)
	;
	// @formatter:on
};
