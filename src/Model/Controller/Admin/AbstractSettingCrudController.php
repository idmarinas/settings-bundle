<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/04/2025, 22:04
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
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Idm\Bundle\Settings\Enums\SettingsEnum;
use function Symfony\Component\Translation\t;

abstract class AbstractSettingCrudController extends AbstractCrudController
{
	public function configureCrud (Crud $crud): Crud
	{
		$t = fn(string $message) => t($message, [], 'IdmSettingsBundle');

		return parent::configureCrud($crud)
			->setEntityLabelInSingular($t('entity.label.setting.singular'))
			->setEntityLabelInPlural($t('entity.label.setting.plural'))
			->setSearchFields(['name', 'description'])
			->setSearchMode(SearchMode::ANY_TERMS)
		;
	}

	public function configureFilters (Filters $filters): Filters
	{
		return parent::configureFilters($filters)
			->add('name')
			->add('description')
			->add('slug')
		;
	}

	public function configureFields (string $pageName): iterable
	{
		$t = fn(string $message) => t($message, [], 'IdmSettingsBundle');

		yield 'translatable' => BooleanField::new('translatable', $t('crud.common.translatable.label'))
			->setHelp($t('crud.common.translatable.help'))
		;
		yield 'translation_domain' => TextField::new('translationDomain', $t('crud.common.translation_domain'))
			->hideOnIndex()
		;
		yield 'id' => IdField::new('id', $t('crud.common.id'))->onlyOnDetail();
		yield 'name' => TextField::new('name', $t('crud.common.name'));
		yield 'description' => TextareaField::new('description', $t('crud.common.description'))->hideOnIndex();
		yield 'domain' => AssociationField::new('domain', $t('crud.setting.domain'))->autocomplete();
		yield 'priority_order' => IntegerField::new('priorityOrder', $t('crud.common.priority_order'));
		yield 'slug' => TextField::new('slug', $t('crud.common.slug'))->onlyOnDetail();

		yield 'type' => ChoiceField::new('type', $t('crud.setting.type'))
			->renderAsBadges()
			->formatValue(fn($value) => t('enum.setting.type.' . $value->value, domain: 'IdmSettingsBundle'))
			->setFormTypeOption('choice_value', fn($value) => is_string($value) ? $value : $value->name)
			->setTranslatableChoices(SettingsEnum::toTranslatableChoices('enum.setting.type.', domain: 'IdmSettingsBundle'))
		;
		yield 'value' => TextField::new('value', $t('crud.common.value'))->hideOnIndex();
	}
}
