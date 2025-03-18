<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 22:14
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

#[ORM\MappedSuperclass()]
abstract class AbstractSettingDomain
{
	use UuidTrait;

	#[ORM\Column(type: Types::STRING, unique: true)]
	protected string $name = 'default';

	#[ORM\Column(type: Types::INTEGER)]
	protected int $priorityOrder = 0;

	#[ORM\Column(type: Types::BOOLEAN)]
	protected bool $enabled = false;

	#[ORM\Column(type: Types::BOOLEAN)]
	protected bool   $readOnly = false;
	#[ORM\Column(type: Types::STRING, unique: true)]
	#[Gedmo\Slug(fields: ['name'], separator: '.', prefix: 'idm.settings.domain.')]
	protected string $cacheKey;

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

	public function getCacheKey (): string
	{
		return $this->cacheKey;
	}

	public function setCacheKey (string $cacheKey): void
	{
		$this->cacheKey = $cacheKey;
	}
}
