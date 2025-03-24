<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/03/2025, 19:17
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    AbstractSettingCrudController.php
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
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Idm\Bundle\Settings\Model\Controller\Admin\Traits\TranslatableFieldsTrait;
use function Symfony\Component\Translation\t;

abstract class AbstractSettingCrudController extends AbstractCrudController
{
	use TranslatableFieldsTrait;

	public function configureCrud (Crud $crud): Crud
	{
		$t = fn(string $message) => t($message, [], 'IdmSettingsBundle');

		return parent::configureCrud($crud)
			->setEntityLabelInSingular($t('entity.label.setting.singular'))
			->setEntityLabelInPlural($t('entity.label.setting.plural'))
		;
	}

	public function configureFields (string $pageName): iterable
	{
		$t = fn(string $message) => t($message, [], 'IdmSettingsBundle');

		yield from $this->translatableFields();

		yield FormField::addTab($t('crud.form.tab.info'), 'fa fa-info');
		yield IdField::new('id', $t('entity.common.id'))->onlyOnDetail();
		yield TextField::new('name', $t('entity.common.name'));
		yield TextareaField::new('description', $t('entity.common.description'))->hideOnIndex();
		yield AssociationField::new('domain', $t('entity.setting.domain'));
		yield IntegerField::new('priorityOrder', $t('entity.common.priority_order'));
		yield TextField::new('slug', $t('entity.common.slug'))->onlyOnDetail();
	}
}
