<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 23:58
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingDomainTest.php
 * @date    18/03/2025
 * @time    23:31
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Tests\Entity;

use App\Entity\Setting\SettingDomain;
use Factory\Setting\SettingDomainFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Translation\TranslatableMessage;
use Zenstruck\Foundry\Test\Factories;

class SettingDomainTest extends KernelTestCase
{
	use Factories;

	public function testSettingDomain ()
	{
		self::bootKernel();

		$oEntity = SettingDomainFactory::random();
		$entity = clone $oEntity->_real();

		$this->assertInstanceOf(SettingDomain::class, $oEntity->_real());
		$this->assertEquals($entity->getName(), (string)$entity);

		$oEntity->setName('new_domain_name');

		$oEntity->_save();
		SettingDomainFactory::assert()->exists(['id' => $entity->getId()]);

		$newEntity = SettingDomainFactory::find($entity->getId());

		$this->assertEquals('new_domain_name', $newEntity->getName());
		$this->assertNotEquals($newEntity->getName(), $entity->getName());

		$oEntity->_delete();

		SettingDomainFactory::assert()->notExists(['id' => $entity->getId()]);
	}

	public function testSettingTranslatable ()
	{
		self::bootKernel();

		$entity = SettingDomainFactory::random();

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
