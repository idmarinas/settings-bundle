<?php
/**
 * Copyright 2021-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/03/2025, 20:00
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    IntegrationTest.php
 * @date    14/03/2025
 * @time    21:52
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Tests\Twig\Extension;

use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Test\IntegrationTestCase;

/**
 * Test Twig Extensions.
 *
 * @group ignore
 */
final class IntegrationTest extends IntegrationTestCase
{
	protected static function getFixturesDirectory (): string
	{
		return __DIR__ . '/Fixtures/';
	}

	protected function getExtensions (): array
	{
		return [];
	}

	protected function getContainer (): ContainerInterface
	{
		$kernel = new Kernel('test', true);
		$kernel->boot();

		return $kernel->getContainer();
	}
}
