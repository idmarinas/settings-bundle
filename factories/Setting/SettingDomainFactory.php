<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 15:27
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingDomainFactory.php
 * @date    16/03/2025
 * @time    19:39
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Factory\Setting;

use App\Entity\Setting\SettingDomain;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<SettingDomain>
 */
final class SettingDomainFactory extends PersistentProxyObjectFactory
{
	public static function class (): string
	{
		return SettingDomain::class;
	}

	/**
	 * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
	 *
	 * @todo add your default values here
	 */
	protected function defaults (): array|callable
	{
		return [
			'enabled'       => self::faker()->boolean(),
			'name'          => implode('_', self::faker()->unique()->words(mt_rand(1, 5))),
			'priorityOrder' => self::faker()->randomDigit() * self::faker()->randomDigit(),
			'readOnly'      => self::faker()->boolean(),
		];
	}

	/**
	 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
	 */
	protected function initialize (): static
	{
		return $this// ->afterInstantiate(function(SettingDomain $settingDomain): void {})
			;
	}
}
