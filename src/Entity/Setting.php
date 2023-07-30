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

namespace Idm\Bundle\Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use Idm\Bundle\Settings\Doctrine\FieldEnum\SettingType;
use Idm\Bundle\Settings\Repository\SettingRepository;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'idm_settings_bundle_setting', columns: ['domain_id', 'name', 'user_id'])
])]
#[ORM\Entity(repositoryClass: SettingRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class Setting
{
    use UuidTrait;
    use SoftDeleteableEntity;

    #[ORM\Column(type: 'string')]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: SettingDomain::class, inversedBy: 'settings')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?SettingDomain $domain = null;

    #[ORM\Column(type: 'string', length: 1000)]
    private string $description = '';

    #[ORM\Column(type: 'string', enumType: SettingType::class)]
    private $type;

    #[ORM\Column(type: 'string', length: 1000)]
    private string $value = '';

    /** It is only necessary if the setting is associated with the user. */
    #[ORM\ManyToOne(targetEntity: UserInterface::class, inversedBy: 'settings')]
    private ?UserInterface $user = null;

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

    public function getDomain(): ?SettingDomain
    {
        return $this->domain;
    }

    public function setDomain(?SettingDomain $domain): static
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
