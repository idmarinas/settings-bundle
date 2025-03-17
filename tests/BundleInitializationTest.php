<?php

/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 23:18
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    BundleInitializationTest.php
 * @date    02/01/2025
 * @time    20:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Tests;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BundleInitializationTest extends KernelTestCase
{
	use CreateKernelCaseTrait;

	public function testInitBundle (): void
	{
		// Boot the kernel.
		$kernel = self::bootKernel([
			'config' => static function (Kernel $kernel) {
//				$kernel->addExtraBundle(BundleName::class);
//				$kernel->addExtraConfig('path/to/file.php');
//				$kernel->addExtraConfig(['extension_name' => ['key_1' => 'value_1']);
//				$kernel->addExtraRoutesFile('path/to/file.php');
			},
		]);

		$container = $kernel->getContainer();

		$this->assertTrue($container->has('kernel'));

		$this->assertArrayHasKey('idm_settings.service.cache_adapter.settings', $container->getRemovedIds());
		$this->assertArrayHasKey('idm_settings.service.cache_adapter.settings.encrypt', $container->getRemovedIds());
		$this->assertArrayHasKey('idm_settings.cache.sodium_marshaller', $container->getRemovedIds());
		$this->assertArrayHasKey('idm_settings.cache', $container->getRemovedIds());
		$this->assertArrayHasKey('idm_settings.encrypt.cache', $container->getRemovedIds());

		$this->assertTrue($container->getParameterBag()->has('idm_settings.parameter.cache_keypair'));
	}
}
