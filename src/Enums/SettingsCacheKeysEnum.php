<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 23:01
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingsCacheKeysEnum.php
 * @date    02/01/2025
 * @time    23:00
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Enums;

enum SettingsCacheKeysEnum: string
{
	case COLLECTION_DOMAIN = 'idm.settings.collection.domain';
	case COLLECTION_ITEMS  = 'idm.settings.collection.items';
	case DOMAIN_ITEM       = 'idm.settings.domain.item';
	case ITEM              = 'idm.settings.item';
}
