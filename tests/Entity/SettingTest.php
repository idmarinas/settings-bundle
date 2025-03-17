<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 22:22
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
use Factory\Setting\SettingDomainFactory;
use Factory\Setting\SettingFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class SettingTest extends KernelTestCase
{
	use Factories;

	public function testSetting ()
	{
		self::bootKernel();
		$serializer = self::getContainer()->get('serializer');

		$entity = SettingFactory::createOne([
			'domain' => SettingDomainFactory::new(),
		])->_real();

		$this->assertIsObject($entity);

		$this->assertInstanceOf(Setting::class, $entity);

		$array = $serializer->normalize($entity, 'array');

		$this->assertIsArray($array);

		$this->assertIsObject($serializer->denormalize($array, Setting::class));
	}
}
