<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/03/2025, 21:22
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    AbstractSettingDomain.php
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
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\Common\Traits\Entity\UuidTrait;
use Idm\Bundle\Settings\Traits\Entity\TranslatableSettingTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass()]
abstract class AbstractSettingDomain
{
	use UuidTrait;
	use TranslatableSettingTrait;

	#[ORM\Column(type: Types::STRING, unique: true)]
	#[Assert\Length(min: 0, max: 255)]
	protected string $name = 'default';

	#[ORM\Column(type: Types::STRING)]
	#[Assert\Length(min: 0, max: 255)]
	protected string $description = '';

	#[ORM\Column(type: Types::INTEGER)]
	protected int $priorityOrder = 0;

	#[ORM\Column(type: Types::BOOLEAN)]
	protected bool $enabled = false;

	#[ORM\Column(type: Types::BOOLEAN)]
	protected bool $readOnly = false;

	#[ORM\Column(type: Types::STRING, unique: true, length: 755)]
	#[Gedmo\Slug(fields: ['name'], separator: '.', prefix: 'domain.')]
	protected string $slug;

	public function __toString ()
	{
		return $this->getName();
	}

	public function getName (): string
	{
		return $this->name;
	}

	public function setName (string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getDescription (): string
	{
		return $this->description;
	}

	public function setDescription (string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getPriorityOrder (): int
	{
		return $this->priorityOrder;
	}

	public function setPriorityOrder (int $priorityOrder): self
	{
		$this->priorityOrder = $priorityOrder;

		return $this;
	}

	public function getEnabled (): bool
	{
		return $this->enabled;
	}

	public function setEnabled (bool $enabled): self
	{
		$this->enabled = $enabled;

		return $this;
	}

	public function getReadOnly (): bool
	{
		return $this->readOnly;
	}

	public function setReadOnly (bool $readOnly): self
	{
		$this->readOnly = $readOnly;

		return $this;
	}

	public function getSlug (): string
	{
		return $this->slug;
	}

	public function setSlug (string $slug): void
	{
		$this->slug = $slug;
	}
}
