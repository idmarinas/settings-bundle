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

namespace Idm\Bundle\Settings\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use Idm\Bundle\Settings\Repository\SettingDomainRepository;

/** Domain for settings of Symfony App */
#[ORM\Table(name: 'settings_setting_domain')]
#[ORM\Entity(repositoryClass: SettingDomainRepository::class)]
abstract class SettingDomain
{
    use UuidTrait;

    public const DEFAULT_NAME = 'default';

    #[ORM\Column(type: Types::STRING, unique: true)]
    protected string $name = '';

    #[ORM\Column(type: Types::INTEGER)]
    protected int $priority = 0;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $enabled = false;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $readOnly = false;

    #[ORM\OneToMany(targetEntity: Setting::class, mappedBy: 'domain')]
    protected ArrayCollection $settings;

    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getReadOnly(): bool
    {
        return $this->readOnly;
    }

    public function setReadOnly(bool $readOnly): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * @return Collection|Setting[]
     */
    public function getSettings(): Collection
    {
        return $this->settings;
    }

    public function addSetting(Setting $setting): self
    {
        if ( ! $this->settings->contains($setting))
        {
            $this->settings[] = $setting;
            $setting->setDomain($this);
        }

        return $this;
    }

    public function removeSetting(Setting $setting): self
    {
        if ($this->settings->removeElement($setting) && $setting->getDomain() === $this)
        {
            // set the owning side to null (unless already changed)
            $setting->setDomain(null);
        }

        return $this;
    }
}
