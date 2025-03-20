<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 24:04
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingRepositoryTest.php
 * @date    20/03/2025
 * @time    13:01
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Tests\Repository;

use DataFixtures\Setting\SettingFixtures;
use Factory\Setting\SettingDomainFactory;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;
use Idm\Bundle\Settings\Model\Repository\AbstractSettingRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class SettingRepositoryTest extends KernelTestCase
{
	use Factories;

	/**
	 * @throws InvalidArgumentException
	 */
	public function testRepository ()
	{
		$repository = $this->getRepository();

		$settings = $repository->getSettingsObjectsByDomain(SettingFixtures::DOMAIN_TEST);

		$this->assertCount(50, $settings);

		$oSetting = $settings->first();

		$setting = $repository->getSettingObject($oSetting->getName());

		$this->assertInstanceOf(AbstractSetting::class, $oSetting);
		$this->assertInstanceOf(AbstractSetting::class, $setting);

		$this->assertEquals(SettingFixtures::DOMAIN_TEST, $oSetting->getDomain()->getName());
		$this->assertEquals(SettingFixtures::DOMAIN_TEST, $setting->getDomain()->getName());

		$this->assertEquals($oSetting->getName(), $setting->getName());
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testRepositoryGetName ()
	{
		$repository = $this->getRepository();

		$string = $repository->getSetting(SettingFixtures::SETTING_TEST . '_string');
		$this->assertIsString($string);

		$int = $repository->getSetting(SettingFixtures::SETTING_TEST . '_int');
		$this->assertIsInt($int);

		$float = $repository->getSetting(SettingFixtures::SETTING_TEST . '_float');
		$this->assertIsFloat($float);

		$bool = $repository->getSetting(SettingFixtures::SETTING_TEST . '_bool');
		$this->assertIsBool($bool);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testNoExist (): void
	{
		$repository = $this->getRepository();

		$setting = $repository->getSettingObject('not_exist_setting');

		$this->assertNull($setting);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testGetSettingsByDomain ()
	{
		$repository = $this->getRepository();
		$domain = SettingDomainFactory::createOne();

		$settings = $repository->getSettingsObjectsByDomain($domain->getName());

		$this->assertCount(0, $settings);

		$settings = $repository->getSettingsObjectsByDomain('unknown_domain');

		$this->assertCount(0, $settings);
	}

	private function getRepository (): AbstractSettingRepository
	{
		self::bootKernel();
		$em = static::getContainer()->get('doctrine.orm.entity_manager');

		return $em->getRepository(AbstractSetting::class);
	}
}
