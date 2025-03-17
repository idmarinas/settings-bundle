<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 14:12
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
	public const string USER_TEST_EMAIL = 'jonny.doe@example.com';

	public const string USER_ADMIN_EMAIL = 'john.doe@example.com';

	public const string USER_EMAIL = 'jane.doe@example.com';

	public const string KEY_USER = 'normal_user_';

	public const string USER_PASS = 'pass_1234_$%';

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
			'settings' => SettingUserFactory::new(['domain' => $domain])->many(mt_rand(1, 10)),
		]);

		// 50% unverified, 50% banned and 50% deleted
		UserFactory::createMany(20, ['password' => self::USER_PASS]);

		$users = UserFactory::all();

		foreach ($users as $key => $user) {
			$this->addReference(self::KEY_USER . $key, $user->_real());
		}
	}
}
