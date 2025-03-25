<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/03/2025, 20:06
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    UserFixtures.php
 * @date    16/03/2025
 * @time    19:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace DataFixtures\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Factory\Setting\SettingDomainFactory;
use Factory\Setting\SettingUserFactory;
use Factory\User\UserFactory;
use ReflectionException;

final class UserFixtures extends Fixture
{
	public const USER_TEST_EMAIL = 'jonny.doe@example.com';

	public const USER_ADMIN_EMAIL = 'john.doe@example.com';

	public const USER_EMAIL = 'jane.doe@example.com';

	public const KEY_USER = 'normal_user_';

	public const USER_PASS = 'pass_1234_$%';

	/**
	 * @throws ReflectionException
	 */
	public function load (ObjectManager $manager): void
	{
		$domain = SettingDomainFactory::createOne(['name' => 'idm_user_user_entity', 'enabled' => true]);

		// 40 additional users added
		// 50% with settings, 50% without settings
		UserFactory::createMany(20, [
			'password' => self::USER_PASS,
			'settings' => SettingUserFactory::new(['domain' => $domain])->many(8),
		]);

		// 50% unverified, 50% banned and 50% deleted
		UserFactory::createMany(20, ['password' => self::USER_PASS]);

		UserFactory::createOne([
			'password' => self::USER_PASS,
			'email'    => self::USER_ADMIN_EMAIL,
			'settings' => SettingUserFactory::new(['domain' => $domain])->many(40),
		]);

		UserFactory::createOne([
			'password' => self::USER_PASS,
			'email'    => self::USER_TEST_EMAIL,
		]);
	}
}
