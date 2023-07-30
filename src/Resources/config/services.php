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

use Idm\Bundle\Settings\Entity\Setting;

return static function (ContainerConfigurator $container)
{
    $container->services()

        // Entities Listeners
        ->set(SettingListener::class)
            ->tag('doctrine.orm.entity_listener',['event' => 'preUpdate', 'entity' => Setting::class, 'lazy' => true])
            ->tag('doctrine.orm.entity_listener',['event' => 'postUpdate', 'entity' => Setting::class, 'lazy' => true])
            ->tag('doctrine.orm.entity_listener',['event' => 'prePersist', 'entity' => Setting::class, 'lazy' => true])
            ->tag('doctrine.orm.entity_listener',['event' => 'postPersist', 'entity' => Setting::class, 'lazy' => true])
            ->tag('doctrine.orm.entity_listener',['event' => 'preRemove', 'entity' => Setting::class, 'lazy' => true])
            ->tag('doctrine.orm.entity_listener',['event' => 'postRemove', 'entity' => Setting::class, 'lazy' => true])

        ->set(SettingsSubscriber::class)
            ->args([new ReferenceConfigurator('idm.bundle.settings.cache')])
            ->tag('kernel.event_subscriber')
    ;
};
