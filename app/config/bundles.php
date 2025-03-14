<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/03/2025, 23:45
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    bundles.php
 * @date    02/01/2025
 * @time    20:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

use DAMA\DoctrineTestBundle\DAMADoctrineTestBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Idm\Bundle\Settings\IdmSettingsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Zenstruck\Foundry\ZenstruckFoundryBundle;

return [
	FrameworkBundle::class        => ['all' => true],
	DoctrineBundle::class         => ['all' => true],

	// Dev-Test Bundles
	MakerBundle::class            => ['all' => true],
	DoctrineFixturesBundle::class => ['all' => true],
	DAMADoctrineTestBundle::class => ['all' => true],
	ZenstruckFoundryBundle::class => ['all' => true],

	// This Bundle
	IdmSettingsBundle::class      => ['all' => true],
];
