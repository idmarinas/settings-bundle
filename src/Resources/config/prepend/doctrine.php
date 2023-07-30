<?php

/**
 * This file is part of Bundle "Idm Settings Bundle".
 *
 * @see https://github.com/idmarinas/settings-bundle/
 *
 * @license https://github.com/idmarinas/settings-bundle/blob/master/LICENSE.txt
 *
 * @since 1.0.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void
{
    $container->extension('doctrine', [
        'orm' => [
            'mappings' => [
                'IdmSettingsBundle' => [
                    'is_bundle' => true,
                    'prefix'    => 'Idm\Bundle\Settings\Entity',
                ],
            ],
        ],
    ]);
};
