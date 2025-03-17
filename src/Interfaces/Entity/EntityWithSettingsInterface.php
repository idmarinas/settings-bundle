<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 13:12
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    EntityWithSettingsInterface.php
 * @date    16/03/2025
 * @time    23:51
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Interfaces\Entity;

use Doctrine\Common\Collections\Collection;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;

interface EntityWithSettingsInterface
{

	public function getSettings (): Collection;

	public function addSetting (AbstractSetting $setting): self;

	public function removeSetting (AbstractSetting $setting): self;
}
