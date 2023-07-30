<?php

/**
 * This file is part of Bundle "Idm Settings Bundle".
 *
 * @see https://github.com/idmarinas/settings-bundle/
 *
 * @license https://github.com/idmarinas/settings-bundle/blob/master/LICENSE.txt
 *
 * @since 1.0.0
 */

namespace Idm\Bundle\Settings\Doctrine\FieldEnum;

/** Setting Enum Type */
enum SettingType: string {
    case String = 'string';
    case Bool = 'bool';
    case Int = 'int';
    case Float = 'float';
}
