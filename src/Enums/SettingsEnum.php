<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/01/2025, 19:34
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

enum SettingsEnum: string
{
	case STRING = 'string';
	case BOOL   = 'bool';
	case INT    = 'int';
	case FLOAT  = 'float';

	public static function values (): array
	{
		return array_column(self::cases(), 'value');
	}

	public function format (mixed $value): float|bool|int|string
	{
		return match ($this) {
			self::BOOL  => (bool)$value,
			self::INT   => (int)$value,
			self::FLOAT => (float)$value,
			default     => (string)$value, // Default is string
		};
	}
}
