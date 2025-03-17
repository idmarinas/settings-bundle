<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 13:15
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    User.php
 * @date    16/03/2025
 * @time    18:59
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace App\Entity\User;

use App\Entity\Setting\SettingUser;
use App\Repository\User\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Settings\Interfaces\Entity\EntityWithSettingsInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;
use Idm\Bundle\User\Model\Entity\AbstractUser;

#[ORM\Table(name: 'idm_user_user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractUser implements EntityWithSettingsInterface
{
	/**
	 * @var Collection<int, AbstractSetting>
	 */
	#[ORM\OneToMany(targetEntity: SettingUser::class, mappedBy: 'user', cascade: ['all'])]
	private Collection $settings;

	public function __construct ()
	{
		$this->settings = new ArrayCollection();
	}

	/**
	 * @return Collection<int, SettingUser>
	 */
	public function getSettings (): Collection
	{
		return $this->settings;
	}

	public function addSetting (SettingUser|AbstractSetting $setting): self
	{
		if (!$this->settings->contains($setting)) {
			$setting->setUser($this);

			$this->settings->add($setting);
		}

		return $this;
	}

	public function removeSetting (SettingUser|AbstractSetting $setting): self
	{
		if ($this->settings->removeElement($setting) && $setting->getUser() === $this) {
			// set the owning side to null (unless already changed)
			$setting->setUser(null);
		}

		return $this;
	}
}
