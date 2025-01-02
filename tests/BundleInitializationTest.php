<?php

/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 03/01/2025, 24:03
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

use Idm\Bundle\Settings\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Cache\SettingsCacheInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BundleInitializationTest extends KernelTestCase
{
	public function testInitBundle (): void
	{
		// Boot the kernel.
		self::bootKernel();

		$this->assertTrue(true);

		$container = self::getContainer();

		$this->assertArrayHasKey('idm_settings.service.cache.adapter.settings', $container->getRemovedIds());
		$this->assertArrayHasKey('idm_settings.service.cache.adapter.settings.encrypt', $container->getRemovedIds());

		$this->assertTrue($container->has(SettingsCacheInterface::class));
		$this->assertTrue($container->has(SettingsCacheEncryptInterface::class));
	}
}
