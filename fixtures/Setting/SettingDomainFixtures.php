<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 14:20
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingDomainFixtures.php
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
use Factory\Setting\SettingDomainFactory;

final class SettingDomainFixtures extends Fixture
{
	public function load (ObjectManager $manager): void
	{
		SettingDomainFactory::createMany(15);
	}
}
