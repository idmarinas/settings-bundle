<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 04/01/2025, 24:28
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

use Exception;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class IdmSettingsBundle extends AbstractBundle
{
	public function configure (DefinitionConfigurator $definition): void
	{
		// @formatter:off
		$definition->rootNode()
			->children()
				->scalarNode('cache_sodium_keypair')
					->info('key must be generated using sodium_crypto_box_keypair() and encode with base64_encode')
					->cannotBeOverwritten()
					->cannotBeEmpty()
					->defaultValue(
						base64_decode('A8sxOR+h35ollRFbQ3KzMDp1gBRbn0UZA0kRjclWRChFgNOF9KTcWg1GNV2rHwnT+0xO3h5Kexpq8MSN+mpOBA==')
					)
					->beforeNormalization()
						->ifString()
						->then(fn ($v) => base64_decode($v, true))
					->end()
					->validate()
						->ifTrue(fn ($v) => ! $this->sodiumKeypairValid($v))
						->thenInvalid('Invalid "sodium_crypto_box_keypair"')
					->end()
				->end()
			->end()
		;
		// @formatter:on
	}

	public function prependExtension (ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->import(dirname(__DIR__) . '/config/cache.php');
	}

	public function loadExtension (array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
	{
		$container->parameters()->set('idm_settings.parameter.cache_keypair', $config['cache_sodium_keypair']);
		$container->import(dirname(__DIR__) . '/config/services.php');
	}

	private function sodiumKeypairValid ($keypair): bool
	{
		$kpLength = SODIUM_CRYPTO_BOX_KEYPAIRBYTES;

		if (strlen($keypair) !== $kpLength) {
			return false;
		}

		try {
			$publicKey = sodium_crypto_box_publickey($keypair);
			$secretKey = sodium_crypto_box_secretkey($keypair);

			return !empty($publicKey) && !empty($secretKey);
		} catch (Exception $e) {
			return false;
		}
	}
}
