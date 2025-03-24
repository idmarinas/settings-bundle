<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 24/03/2025, 19:17
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    AbstractCrudController.php
 * @date    24/03/2025
 * @time    19:15
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
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController as BaseController;
use Idm\Bundle\Settings\Model\Controller\Admin\Traits\TranslatableFieldsTrait;

abstract class AbstractCrudController extends BaseController
{
	use TranslatableFieldsTrait;

	public function configureCrud (Crud $crud): Crud
	{
		return parent::configureCrud($crud)
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
}
