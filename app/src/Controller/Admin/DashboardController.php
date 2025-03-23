<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/03/2025, 19:38
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    DashboardController.php
 * @date    23/03/2025
 * @time    19:35
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Controller\Admin;

use App\Entity\Setting\Setting;
use App\Entity\Setting\SettingDomain;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard('/admin', 'dashboard')]
class DashboardController extends AbstractDashboardController
{
	public function configureDashboard (): Dashboard
	{
		return Dashboard::new()
			->setTitle('Html')
		;
	}

	public function configureMenuItems (): iterable
	{
		yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
		yield MenuItem::linkToCrud('Setting', 'fas fa-list', Setting::class);
		yield MenuItem::linkToCrud('Setting Domain', 'fas fa-list', SettingDomain::class);
	}
}
