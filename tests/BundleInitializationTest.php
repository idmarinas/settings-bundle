<?php

/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/01/2025, 24:48
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
use Idm\Bundle\Settings\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Cache\SettingsCacheInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

final class BundleInitializationTest extends KernelTestCase
{
	protected static function createKernel (array $options = []): KernelInterface
	{
		/** @var Kernel $kernel */
		$kernel = parent::createKernel($options);
		$kernel->handleOptions($options);

		return $kernel;
	}

	public function testInitBundle (): void
	{
		// Boot the kernel.
		self::bootKernel([
			'config' => static function (Kernel $kernel) {
				$kernel->addExtraConfig(__DIR__ . '/config/idm_settings.php');
			},
		]);

		$container = self::getContainer();

		$this->assertTrue($container->has('kernel'));

		$this->assertTrue($container->getParameterBag()->has('idm_settings.parameter.cache_keypair'));

		$this->assertArrayHasKey('idm_settings.service.cache.adapter.settings', $container->getRemovedIds());
		$this->assertArrayHasKey('idm_settings.service.cache.adapter.settings.encrypt', $container->getRemovedIds());
		$this->assertArrayHasKey('idm_settings.cache.sodium_marshaller', $container->getRemovedIds());

		$this->assertTrue($container->has(SettingsCacheInterface::class));
		$this->assertTrue($container->has(SettingsCacheEncryptInterface::class));
	}
}
