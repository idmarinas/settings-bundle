<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 16/03/2025, 19:50
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingUserFixtures.php
 * @date    16/03/2025
 * @time    19:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace DataFixtures\Setting;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SettingUserFixtures extends Fixture
{
	public function load (ObjectManager $manager): void
	{
		// $product = new Product();
		// $manager->persist($product);

		$manager->flush();
	}
}
