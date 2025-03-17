<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 17:57
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    CacheKeyEnum.php
 * @date    02/01/2025
 * @time    23:00
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Enums;

use Symfony\Component\String\Slugger\AsciiSlugger;

enum CacheKeyEnum: string
{
	/** List of settings */
	case COLLECTION = 'idm_settings.collection';

	/** Item of setting */
	case ITEM = 'idm_settings.item';

	case DOMAIN = 'idm_settings.domain';

	public static function formatCacheItem (string $value): string
	{
		return self::slugged(self::ITEM->value . '.' . $value);
	}

	public static function formatCacheDomain (string $value): string
	{
		return self::slugged(self::DOMAIN->value . '.' . $value);
	}

	protected static function slugged (string $value): string
	{
		$slugger = new AsciiSlugger();

		return $slugger->slug($value, '.');
	}
}
