<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 22:19
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingTest.php
 * @date    17/03/2025
 * @time    22:10
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Tests\Entity;

use App\Entity\Setting\Setting;
use App\Entity\Setting\SettingUser;
use Factory\Setting\SettingDomainFactory;
use Factory\Setting\SettingFactory;
use Factory\Setting\SettingUserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Translation\TranslatableMessage;
use Zenstruck\Foundry\Test\Factories;

class SettingTest extends KernelTestCase
{
	use Factories;

	public function testSetting ()
	{
		self::bootKernel();
		$serializer = self::getContainer()->get('serializer');

		$entity = SettingFactory::createOne([
			'name'   => 'test setting',
			'domain' => SettingDomainFactory::new(),
		]);

		$this->assertIsObject($entity->_real());

		$this->assertEquals($entity->getName(), (string)$entity->_real());

		$this->assertInstanceOf(Setting::class, $entity->_real());

		$array = $serializer->normalize($entity->_real(), 'array');

		$this->assertIsArray($array);

		$this->assertIsObject($serializer->denormalize($array, Setting::class));

		SettingFactory::assert()->count(155);

		$entity->_delete();

		SettingFactory::assert()->count(154);
	}

	public function testSettingUpdate ()
	{
		self::bootKernel();

		$oEntity = SettingFactory::random();
		$entity = clone $oEntity->_real();
		$oEntity->setName('changed_name');

		$this->assertInstanceOf(Setting::class, $oEntity->_real());

		$oEntity->_save();

		SettingFactory::assert()->exists(['id' => $entity->getId()]);

		$newEntity = SettingFactory::find($entity->getId());

		$this->assertEquals('changed_name', $newEntity->getName());
		$this->assertNotEquals($newEntity->getName(), $entity->getName());
	}

	public function testSettingDelete ()
	{
		self::bootKernel();

		$entity = SettingUserFactory::random();
		$entityId = $entity->getId();

		$this->assertNotNull($entityId);

		$this->assertInstanceOf(SettingUser::class, $entity->_real());

		$entity->_delete();

		SettingUserFactory::assert()->notExists(['id' => $entityId]);
	}

	public function testSettingTranslatable ()
	{
		self::bootKernel();

		$entity = SettingFactory::random();

		$this->assertNull($entity->translateName());

		$this->assertNull($entity->translateDescription());

		$entity->setTranslatable(true);

		$entity->_save();

		$this->assertInstanceOf(TranslatableMessage::class, $entity->translateName());
		$this->assertInstanceOf(TranslatableMessage::class, $entity->translateDescription());

		$this->assertEquals($entity->getName(), $entity->translateName()->getMessage());
		$this->assertEquals([], $entity->translateName()->getParameters());
		$this->assertEquals($entity->getTranslationDomain(), $entity->translateName()->getDomain());

		$this->assertEquals($entity->getDescription(), $entity->translateDescription()->getMessage());
		$this->assertEquals([], $entity->translateName()->getParameters());
		$this->assertEquals($entity->getTranslationDomain(), $entity->translateDescription()->getDomain());
	}
}
