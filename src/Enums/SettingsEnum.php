<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 14/04/2025, 21:22
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingsEnum.php
 * @date    04/01/2025
 * @time    12:30
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Enums;

use Idm\Bundle\Common\Traits\Enums\EnumToArrayTrait;
use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum SettingsEnum: string implements TranslatableInterface
{
	use EnumToArrayTrait;

	case STRING = 'string';
	case BOOL   = 'bool';
	case INT    = 'int';
	case FLOAT  = 'float';

	public function format (mixed $value): float|bool|int|string
	{
		return match ($this) {
			self::BOOL  => (bool)$value,
			self::INT   => (int)$value,
			self::FLOAT => (float)$value,
			default     => (string)$value, // Default is string
		};
	}

	public function trans (TranslatorInterface $translator, ?string $locale = null): string
	{
		$key = 'enum.setting.type.' . strtolower($this->name);

		return $translator->trans($key, domain: 'IdmSettingsBundle', locale: $locale);
	}
}
