<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/03/2025, 12:49
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    TranslatableFieldsTrait.php
 * @date    22/03/2025
 * @time    12:43
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Model\Controller\Admin\Traits;

use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use function Symfony\Component\Translation\t;

trait TranslatableFieldsTrait
{
	public function translatableFields (): iterable
	{
		$t = fn(string $message) => t($message, [], 'IdmSettingsBundle');

		yield FormField::addTab($t('crud.form.tab.translation'), 'fa fa-language');
		yield BooleanField::new('translatable', $t('entity.common.translatable.label'))
			->setHelp($t('entity.common.translatable.help'))
		;
		yield TextField::new('translationDomain', $t('entity.common.translation_domain'))->hideOnIndex();
	}
}
