<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/03/2025, 18:22
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingCrudControllerTest.php
 * @date    23/03/2025
 * @time    19:40
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Tests\Controller\Admin\Setting;

use App\Controller\Admin\DashboardController;
use App\Controller\Admin\Setting\SettingCrudController;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use Idm\Bundle\Settings\Tests\CreateKernelCaseTrait;
use Symfony\Component\HttpFoundation\Request;

class SettingCrudControllerTest extends AbstractCrudTestCase
{
	use CreateKernelCaseTrait;

	public function testIndexPage ()
	{
		$this->client->request(Request::METHOD_GET, $this->generateIndexUrl());

		$this->assertResponseIsSuccessful();
	}

	protected function setUp (): void
	{
		$this->client = self::createClient([
			'environment' => 'admin',
		]);
		$container = self::getContainer();
		$this->entityManager = $container->get(EntityManagerInterface::class);
		$this->adminUrlGenerator = $container->get(AdminUrlGenerator::class);
	}

	protected function getControllerFqcn (): string
	{
		return SettingCrudController::class;
	}

	protected function getDashboardFqcn (): string
	{
		return DashboardController::class;
	}
}
