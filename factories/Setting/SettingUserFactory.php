<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 22:56
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingUserFactory.php
 * @date    16/03/2025
 * @time    19:39
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Factory\Setting;

use App\Entity\Setting\SettingUser;
use Idm\Bundle\Settings\Enums\SettingsEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<SettingUser>
 */
final class SettingUserFactory extends PersistentProxyObjectFactory
{
	public static function class (): string
	{
		return SettingUser::class;
	}

	/**
	 * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
	 *
	 * @todo add your default values here
	 */
	protected function defaults (): array|callable
	{
		/** @var SettingsEnum $type */
		$type = self::faker()->randomElement(SettingsEnum::cases());
		$value = match ($type) {
			SettingsEnum::BOOL  => self::faker()->boolean(),
			SettingsEnum::INT   => self::faker()->randomDigit(),
			SettingsEnum::FLOAT => self::faker()->randomFloat(),
			default             => self::faker()->text(255),
		};

		return [
			'description' => self::faker()->text(255),
			'name'        => self::faker()->unique()->words(),
			'domain'      => SettingDomainFactory::new(),
			'type'        => $type,
			'value'       => $value,
		];
	}

	/**
	 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
	 */
	protected function initialize (): static
	{
		return $this// ->afterInstantiate(function(SettingUser $settingUser): void {})
			;
	}
}
