<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 13:15
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    SettingUser.php
 * @date    16/03/2025
 * @time    18:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Entity\Setting;

use App\Entity\User\User;
use App\Repository\Setting\SettingUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;

#[ORM\Table(name: 'idm_settings_setting_user')]
#[ORM\Entity(repositoryClass: SettingUserRepository::class)]
#[ORM\UniqueConstraint(name: 'idm_settings_uniq_idx_setting_user', columns: ['domain_id', 'name', 'user_id'])]
class SettingUser extends AbstractSetting
{
	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'settings')]
	protected ?User $user = null;

	public function getUser (): ?User
	{
		return $this->user;
	}

	public function setUser (?User $user): self
	{
		$this->user = $user;

		return $this;
	}
}
