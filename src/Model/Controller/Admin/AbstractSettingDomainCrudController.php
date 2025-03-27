<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/03/2025, 18:33
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    AbstractSettingDomainCrudController.php
 * @date    22/03/2025
 * @time    11:21
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Model\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use function Symfony\Component\Translation\t;

abstract class AbstractSettingDomainCrudController extends AbstractSettingCrudController
{
	public function configureCrud (Crud $crud): Crud
	{
		$t = fn(string $message) => t($message, [], 'IdmSettingsBundle');

		return parent::configureCrud($crud)
			->setEntityLabelInSingular($t('entity.label.setting_domain.singular'))
			->setEntityLabelInPlural($t('entity.label.setting_domain.plural'))
		;
	}

	public function configureFields (string $pageName): iterable
	{
		$t = fn(string $message) => t($message, [], 'IdmSettingsBundle');

		foreach (parent::configureFields($pageName) as $key => $field) {
			if ('domain' !== $key) {
				yield $field;
			}
		}

		yield FormField::addTab($t('crud.form.tab.options'), 'fa fa-info');
		yield BooleanField::new('enabled', $t('crud.common.enabled'));
		yield BooleanField::new('readOnly', $t('crud.common.read_only'));
	}
}
