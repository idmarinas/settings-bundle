<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 24:10
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingUserRepositoryTest.php
 * @date    20/03/2025
 * @time    22:44
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

declare(strict_types=1);

namespace Idm\Bundle\Settings\Tests\Repository;

use App\Entity\Setting\SettingUser;
use App\Repository\Setting\SettingUserRepository;
use DataFixtures\User\UserFixtures;
use Factory\User\UserFactory;
use Idm\Bundle\Settings\Exception\RequiredFieldMissingException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class SettingUserRepositoryTest extends KernelTestCase
{
	use  Factories;

	/**
	 * @throws InvalidArgumentException
	 * @throws RequiredFieldMissingException
	 */
	public function testSettingsEntity (): void
	{
		$repository = $this->getRepository();

		$settings = $repository->getSettingsObjectsByDomain('idm_user_user_entity');

		$this->assertCount(200, $settings);

		$user = UserFactory::find(['email' => UserFixtures::USER_ADMIN_EMAIL]);

		$settings = $repository->getSettingsOfEntityById($user->getId());

		$this->assertCount(40, $settings);

		$user = UserFactory::find(['email' => UserFixtures::USER_TEST_EMAIL]);

		$settings = $repository->getSettingsOfEntityById($user->getId());

		$this->assertCount(0, $settings);
	}

	private function getRepository (): SettingUserRepository
	{
		self::bootKernel();
		$em = static::getContainer()->get('doctrine.orm.entity_manager');

		return $em->getRepository(SettingUser::class);
	}
}
