<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 24:05
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingDomainRepositoryTest.php
 * @date    20/03/2025
 * @time    18:31
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Tests\Repository;

use Idm\Bundle\Settings\Model\Entity\AbstractSettingDomain;
use Idm\Bundle\Settings\Model\Repository\AbstractSettingDomainRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class SettingDomainRepositoryTest extends KernelTestCase
{
	use Factories;

	/**
	 * @throws InvalidArgumentException
	 */
	public function testSomething (): void
	{
		self::bootKernel();

		$em = static::getContainer()->get('doctrine.orm.entity_manager');
		/** @var AbstractSettingDomainRepository $repository */
		$repository = $em->getRepository(AbstractSettingDomain::class);

		$domain = $repository->getDomainObject('not-existing-domain');

		$this->assertNull($domain);
	}
}
