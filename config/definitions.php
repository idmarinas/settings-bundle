<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 15/03/2025, 13:04
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    definitions.php
 * @date    15/03/2025
 * @time    11:36
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;

return function (DefinitionConfigurator $definition) {
	$isValidKeypair = function ($keypair): bool {
		$kpLength = SODIUM_CRYPTO_BOX_KEYPAIRBYTES;

		if (strlen($keypair) !== $kpLength) {
			return false;
		}

		try {
			$publicKey = sodium_crypto_box_publickey($keypair);
			$secretKey = sodium_crypto_box_secretkey($keypair);

			return !empty($publicKey) && !empty($secretKey);
		} catch (Exception) {
			return false;
		}
	};

// @formatter:off
	$definition
		->rootNode()
			->children()
				->arrayNode('cache_keypair')
					->info("key must be generated using sodium_crypto_box_keypair() and encode with base64_encode.\nYou need generate your own keypair")
					->beforeNormalization()->castToArray()->end()
					->defaultValue([base64_decode('A8sxOR+h35ollRFbQ3KzMDp1gBRbn0UZA0kRjclWRChFgNOF9KTcWg1GNV2rHwnT+0xO3h5Kexpq8MSN+mpOBA==')])
					->requiresAtLeastOneElement()
					->scalarPrototype()
						->cannotBeOverwritten()
						->cannotBeEmpty()
						->validate()
							->ifTrue(fn ($v): bool => !$isValidKeypair($v))
							->thenInvalid('Invalid "sodium_crypto_box_keypair": %s')
						->end()
					->end()
				->end()
			->end()
		->end()
	;
// @formatter:on
};
