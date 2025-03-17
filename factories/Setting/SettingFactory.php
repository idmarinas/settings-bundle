<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 15:26
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingFactory.php
 * @date    16/03/2025
 * @time    19:39
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Factory\Setting;

use App\Entity\Setting\Setting;
use Factory\AbstractSettingDomainFactory;
use Idm\Bundle\Settings\Enums\SettingsEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Setting>
 */
final class SettingFactory extends PersistentProxyObjectFactory
{
	/**
	 * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
	 *
	 * @todo inject services if required
	 */
	public function __construct () {}

	public static function class (): string
	{
		return Setting::class;
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
			default             => self::faker()->text(1000),
		};

		return [
			'description'   => self::faker()->text(1000),
			'name'          => implode('_', self::faker()->unique()->words()),
			'type'          => $type,
			'value'         => $value,
			'priorityOrder' => self::faker()->randomNumber(),
		];
	}

	/**
	 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
	 */
	protected function initialize (): static
	{
		return $this// ->afterInstantiate(function(Setting $setting): void {})
			;
	}
}
