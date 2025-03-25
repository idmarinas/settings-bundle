<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/03/2025, 20:04
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingFixtures.php
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
use Factory\Setting\SettingFactory;
use Idm\Bundle\Settings\Enums\SettingsEnum;

final class SettingFixtures extends Fixture
{
	public const SETTING_TEST = 'setting_test';

	public const DOMAIN_TEST = 'domain_test';

	public const SETTING_TEST_STRING = 'setting_test_string';

	public const SETTING_TEST_INT = 500;

	public const SETTING_TEST_FLOAT = 45.36;

	public const SETTING_TEST_BOOL = true;

	public function load (ObjectManager $manager): void
	{
		SettingFactory::createMany(100, ['domain' => SettingDomainFactory::random()]);

		SettingFactory::createOne([
			'name'   => self::SETTING_TEST . '_string',
			'value'  => self::SETTING_TEST_STRING,
			'type'   => SettingsEnum::STRING,
			'domain' => SettingDomainFactory::random(),
		]);
		SettingFactory::createOne([
			'name'   => self::SETTING_TEST . '_int',
			'value'  => self::SETTING_TEST_INT,
			'type'   => SettingsEnum::INT,
			'domain' => SettingDomainFactory::random(),
		]);
		SettingFactory::createOne([
			'name'   => self::SETTING_TEST . '_float',
			'value'  => self::SETTING_TEST_FLOAT,
			'type'   => SettingsEnum::FLOAT,
			'domain' => SettingDomainFactory::random(),
		]);
		SettingFactory::createOne([
			'name'   => self::SETTING_TEST . '_bool',
			'value'  => self::SETTING_TEST_BOOL,
			'type'   => SettingsEnum::BOOL,
			'domain' => SettingDomainFactory::random(),
		]);

		$domain = SettingDomainFactory::createOne(['name' => self::DOMAIN_TEST]);

		SettingFactory::createMany(50, ['domain' => $domain]);
	}
}
