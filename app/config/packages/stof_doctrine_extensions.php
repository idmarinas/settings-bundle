<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 02/01/2025, 21:58
 *
 * @project IDMarinas Settings Bundle
 * @see https://github.com/idmarinas/settings-bundle
 *
 * @file stof_doctrine_extensions.php
 * @date 02/01/2025
 * @time 20:33
 *
 * @author Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since 1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
	$container->extension('stof_doctrine_extensions', [
		'default_locale'       => '%kernel.default_locale%',
		'translation_fallback' => true,
		'orm'                  => [
			# Activate the extensions you want
			'default' => [
				'translatable'        => false,
				'timestampable'       => false,
				'blameable'           => false,
				'sluggable'           => false,
				'tree'                => false,
				'loggable'            => false,
				'sortable'            => false,
				'softdeleteable'      => false,
				'uploadable'          => false,
				'reference_integrity' => false,
			],
		],
	]);
};
