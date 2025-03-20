<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 20/03/2025, 23:20
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingsWithEntityInterface.php
 * @date    20/03/2025
 * @time    23:19
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Interfaces\Entity;

interface SettingsWithEntityInterface
{
	public function getEntity (): ?EntityWithSettingsInterface;

	public function setEntity (EntityWithSettingsInterface $entity): self;
}
