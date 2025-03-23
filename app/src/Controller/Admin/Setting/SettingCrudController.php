<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/03/2025, 19:38
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingCrudController.php
 * @date    23/03/2025
 * @time    19:38
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Controller\Admin\Setting;

use App\Entity\Setting\Setting;
use Idm\Bundle\Settings\Model\Controller\Admin\AbstractSettingCrudController;

final class SettingCrudController extends AbstractSettingCrudController
{
	public static function getEntityFqcn (): string
	{
		return Setting::class;
	}
}
