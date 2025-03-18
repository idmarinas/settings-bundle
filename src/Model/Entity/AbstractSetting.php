<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 21:34
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    AbstractSetting.php
 * @date    14/03/2025
 * @time    21:52
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Model\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use Idm\Bundle\Settings\Enums\SettingsEnum;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
abstract class AbstractSetting
{
	use UuidTrait;

	#[ORM\Column(type: Types::STRING)]
	#[Assert\Length(min: 3, max: 255)]
	protected ?string $name = null;

	#[ORM\ManyToOne(targetEntity: AbstractSettingDomain::class, inversedBy: 'settings')]
	#[ORM\JoinColumn(nullable: false)]
	protected ?AbstractSettingDomain $domain = null;

	#[ORM\Column(type: Types::STRING, length: 1000)]
	#[Assert\Length(min: 0, max: 1000)]
	protected string $description = '';

	#[ORM\Column(type: Types::STRING, enumType: SettingsEnum::class)]
	protected SettingsEnum $type = SettingsEnum::STRING;

	#[ORM\Column(type: Types::STRING, length: 1000)]
	#[Assert\Length(min: 0, max: 1000)]
	protected string $value = '';

	#[ORM\Column(type: Types::INTEGER)]
	protected int $priorityOrder = 0;

	#[ORM\Column(type: Types::STRING, length: 510, unique: true)]
	protected string $cacheKey;

	public function __toString (): string
	{
		return $this->domain . ') ' . $this->name;
	}

	public function getName (): string
	{
		return $this->name;
	}

	public function setName (string $name): static
	{
		$this->name = $name;

		return $this;
	}

	public function getDescription (): string
	{
		return $this->description;
	}

	public function setDescription (string $description): static
	{
		$this->description = $description;

		return $this;
	}

	public function getType (): SettingsEnum
	{
		return $this->type;
	}

	public function setType (SettingsEnum $type): static
	{
		$this->type = $type;

		return $this;
	}

	public function getValue (): string
	{
		return $this->value;
	}

	public function setValue (string $value): static
	{
		$this->value = $value;

		return $this;
	}

	public function getDomain (): ?AbstractSettingDomain
	{
		return $this->domain;
	}

	public function setDomain (?AbstractSettingDomain $domain): static
	{
		$this->domain = $domain;

		return $this;
	}

	public function getPriorityOrder (): int
	{
		return $this->priorityOrder;
	}

	public function setPriorityOrder (int $priorityOrder): static
	{
		$this->priorityOrder = $priorityOrder;

		return $this;
	}

	public function getCacheKey (): string
	{
		return $this->cacheKey;
	}

	public function setCacheKey (string $cacheKey): static
	{
		$this->cacheKey = $cacheKey;

		return $this;
	}

	#[ORM\PrePersist]
	#[ORM\PreUpdate]
	public function doGenerateCacheKey (): void
	{
		$entityId = method_exists($this, 'getEntity') ? $this->getEntity() . '.' : '';
		$key = 'idm.settings.' . $entityId . $this->getDomain()->getName() . '.' . $this->getName();

		$this->setCacheKey((new AsciiSlugger())->slug($key, '.'));
	}

	public function getFormatedValue (): float|bool|int|string
	{
		return $this->getType()->format($this->getValue());
	}
}
