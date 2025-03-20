<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/03/2025, 24:12
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingsKeysEnum.php
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

enum SettingsKeysEnum: string
{
	case COLLECTION_SETTINGS_BY_DOMAIN               = 'idm.settings.collection.settings.by.domain';
	case COLLECTION_SETTINGS                         = 'idm.settings.collection.settings';
	case COLLECTION_DOMAINS                          = 'idm.settings.collection.domains';
	case COLLECTION_SETTINGS_BY_ENTITY_ID            = 'idm.settings.collection.entity.id';
	case COLLECTION_SETTINGS_BY_ENTITY_ID_AND_DOMAIN = 'idm.settings.collection.entity.id.and.domain';
	case DOMAIN                                      = 'idm.settings.domain';
	case SETTING                                     = 'idm.settings.setting';

	public static function slug (string $entityName, string $name): string
	{
		$key = $entityName . '.' . $name;

		return ((new AsciiSlugger())->slug($key, '.'));
	}
}
