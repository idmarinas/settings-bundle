<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 25/03/2025, 20:02
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    IdmSettingsBundle.php
 * @date    02/01/2025
 * @time    20:33
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings;

use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheEncryptInterface;
use Idm\Bundle\Settings\Interfaces\Cache\SettingsCacheInterface;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class IdmSettingsBundle extends AbstractBundle implements CompilerPassInterface
{
	public function build (ContainerBuilder $container): void
	{
		parent::build($container);

		$container->addCompilerPass($this);
	}

	public function configure (DefinitionConfigurator $definition): void
	{
		$definition->import(dirname(__DIR__) . '/config/definitions.php');
	}

	public function loadExtension (array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$builder->setParameter('idm_settings.parameter.cache_keypair', $config['cache_keypair']);
		$container->import(dirname(__DIR__) . '/config/services.php');

		$builder->registerForAutoconfiguration(SettingsCacheInterface::class)->addTag(
			'idm_settings.repository.settings'
		);

		$builder->registerForAutoconfiguration(SettingsCacheEncryptInterface::class)->addTag(
			'idm_settings.repository.settings.encrypt'
		);
	}

	public function prependExtension (ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->import(dirname(__DIR__) . '/config/cache.php');
	}

	public function process (ContainerBuilder $container): void
	{
		$taggedServices = $container->findTaggedServiceIds('idm_settings.repository.settings');

		foreach (array_keys($taggedServices) as $id) {
			$container->findDefinition($id)->addMethodCall('setCache', [new Reference('idm_settings.cache')]);
		}

		$taggedServices = $container->findTaggedServiceIds('idm_settings.repository.settings.encrypt');

		foreach (array_keys($taggedServices) as $id) {
			$container->findDefinition($id)->addMethodCall('setCacheEncrypt', [new Reference('idm_settings.encrypt.cache')]);
		}
	}
}
