<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/03/2025, 13:16
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    doctrine.php
 * @date    02/01/2025
 * @time    20:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Entity\Setting\Setting;
use App\Entity\Setting\SettingDomain;
use App\Entity\User\User;
use Idm\Bundle\Settings\IdmSettingsBundle;
use Idm\Bundle\Settings\Interfaces\Entity\EntityWithSettingsInterface;
use Idm\Bundle\Settings\Interfaces\Entity\SettingsWithEntityInterface;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;
use Idm\Bundle\Settings\Model\Entity\AbstractSettingDomain;
use ReflectionClass;
use Symfony\Component\Filesystem\Filesystem;
use function Symfony\Component\String\u;

return static function (ContainerConfigurator $container) {
	$getDatabaseCache = function (): string {
		$dir = dirname(__DIR__, 3) . '/var/cache/database';

		$filesystem = new Filesystem();

		if (!$filesystem->exists($dir)) {
			$filesystem->mkdir($dir);
		}

		return $dir;
	};

	$dbName = (new ReflectionClass(IdmSettingsBundle::class))->getShortName();
	$dbName = u($dbName)->snake()->toString();

	$container->extension('doctrine', [
		'dbal' => [
			'driver'         => 'pdo_sqlite',
			'url'            => sprintf('sqlite:///%s/%s_%s.sqlite', $getDatabaseCache(), $dbName, $container->env()),
			'use_savepoints' => true,
		],
		'orm'  => [
			'enable_lazy_ghost_objects'   => true,
			'auto_generate_proxy_classes' => true,
			'auto_mapping'                => false,
			'controller_resolver'         => [
				'auto_mapping' => false,
			],
			'mappings'                    => [
				'Tests' => [
					'is_bundle' => false,
					'mapping'   => true,
					'type'      => 'attribute',
					'dir'       => dirname(__DIR__, 2) . '/src/Entity',
					'prefix'    => 'App\Entity',
				],
			],
			'resolve_target_entities'     => [
				AbstractSetting::class             => Setting::class,
				AbstractSettingDomain::class       => SettingDomain::class,
				EntityWithSettingsInterface::class => User::class,
			],
		],
	]);
};
