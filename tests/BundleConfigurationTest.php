<?php

/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/03/2025, 19:59
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    BundleConfigurationTest.php
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
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

final class BundleConfigurationTest extends KernelTestCase
{
	use CreateKernelCaseTrait;

	public function testInitBundleInvalidConfiguration (): void
	{
		$this->expectException(InvalidConfigurationException::class);
		$this->expectExceptionMessage('Invalid "sodium_crypto_box_keypair"');

		// Boot the kernel.
		self::bootKernel([
			'config' => static function (Kernel $kernel): void {
				$kernel->addExtraConfig([
					'idm_settings' => [
						'cache_keypair' => 'invalid_key',
					],
				]);
			},
		]);
	}
}
