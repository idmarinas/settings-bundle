<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 18/03/2025, 22:47
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    TranslatableSettingTrait.php
 * @date    18/03/2025
 * @time    22:35
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Traits\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\Translation\t;

trait TranslatableSettingTrait
{
	#[ORM\Column(type: Types::STRING)]
	#[Assert\Length(min: 0, max: 255)]
	protected string $translationDomain = 'IdmSettingsBundle';

	#[ORM\Column(type: Types::BOOLEAN)]
	protected bool $translatable = false;

	public function getTranslationDomain (): string
	{
		return $this->translationDomain;
	}

	public function setTranslationDomain (string $translationDomain): static
	{
		$this->translationDomain = $translationDomain;

		return $this;
	}

	public function isTranslatable (): bool
	{
		return $this->translatable;
	}

	public function setTranslatable (bool $translatable): static
	{
		$this->translatable = $translatable;

		return $this;
	}

	public function translateName (array $parameters = []): ?TranslatableMessage
	{
		if ($this->isTranslatable()) {
			return t($this->getName(), $parameters, $this->getTranslationDomain());
		}

		return null;
	}

	public function translateDescription (array $parameters = []): ?TranslatableMessage
	{
		if ($this->isTranslatable()) {
			return t($this->getDescription(), $parameters, $this->getTranslationDomain());
		}

		return null;
	}
}
