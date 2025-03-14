<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/03/2025, 22:52
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    CreateKernelCaseTrait.php
 * @date    14/03/2025
 * @time    21:52
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\Settings\Tests;

use Symfony\Component\HttpKernel\KernelInterface;

trait CreateKernelCaseTrait
{
	protected static function createKernel (array $options = []): KernelInterface
	{
		$kernel = parent::createKernel($options);
		$kernel->handleOptions($options);

		return $kernel;
	}
}
