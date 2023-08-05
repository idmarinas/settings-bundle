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

use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use Idm\Bundle\Settings\Doctrine\FieldEnum\SettingType;
use Idm\Bundle\Settings\Repository\SettingRepository;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: 'settings_setting', uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'idm_settings_bundle_setting', columns: ['domain_id', 'name', 'user_id'])
])]
#[ORM\Entity(repositoryClass: SettingRepository::class)]
abstract class AbstractSetting
{
    use UuidTrait;

    #[ORM\Column(type: 'string')]
    protected ?string $name = null;

    #[ORM\ManyToOne(targetEntity: SettingDomain::class, inversedBy: 'settings')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    protected ?AbstractSettingDomain $domain = null;

    #[ORM\Column(type: 'string', length: 1000)]
    protected string $description = '';

    #[ORM\Column(type: 'string', enumType: SettingType::class)]
    protected SettingType $type;

    #[ORM\Column(type: 'string', length: 1000)]
    protected string $value = '';

    /** It is only necessary if the setting is associated with the user. */
    #[ORM\ManyToOne(targetEntity: UserInterface::class, inversedBy: 'settings')]
    protected ?UserInterface $user = null;

    public function __toString(): string
    {
        return $this->domain.') '.$this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): SettingType
    {
        return $this->type;
    }

    public function setType(SettingType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getDomain(): ?AbstractSettingDomain
    {
        return $this->domain;
    }

    public function setDomain(?AbstractSettingDomain $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function formatedValue()
    {
        return match ($this->getType()) {
            'bool' => (bool) $this->getValue(),
            'int' => (int) $this->getValue(),
            'float' => (float) $this->getValue(),
            default => (string) $this->getValue(), // -- Default is string
        };
    }
}
