<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 15/03/2025, 13:11
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

use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\UX\TwigComponent\TwigComponentBundle;

final class IdmSettingsBundle extends AbstractBundle
{
	public function configure (DefinitionConfigurator $definition): void
	{
		$definition->import(dirname(__DIR__) . '/config/definitions.php');
	}

	public function loadExtension (array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$builder->setParameter('idm_settings.parameter.cache_keypair', $config['cache_keypair']);
		$container->import(dirname(__DIR__) . '/config/services.php');
	}

	public function prependExtension (ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->import(dirname(__DIR__) . '/config/cache.php');

		if ($builder::willBeAvailable('symfony/twig-bundle', TwigBundle::class, ['twig/twig'])) {
			$container->import(dirname(__DIR__) . '/config/twig.php');
		}

		if ($builder::willBeAvailable('symfony/ux-twig-component', TwigComponentBundle::class, ['symfony/twig-bundle'])) {
			$container->import(dirname(__DIR__) . '/config/twig_component.php');
		}
	}
}
