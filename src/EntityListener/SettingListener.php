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

namespace Idm\Bundle\Settings\EntityListener;

use Idm\Bundle\Settings\Entity\Setting;
use Idm\Bundle\Settings\Event\SettingsEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SettingListener
{
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function prePersist(Setting $setting): void
    {
        $this->eventDispatcher->dispatch(new SettingsEvent($setting), SettingsEvent::PRE_CREATE_SETTING);
    }

    public function postPersist(Setting $setting): void
    {
        $this->eventDispatcher->dispatch(new SettingsEvent($setting), SettingsEvent::POST_CREATE_SETTING);
    }

    public function preUpdate(Setting $setting): void
    {
        $this->eventDispatcher->dispatch(new SettingsEvent($setting), SettingsEvent::PRE_UPDATE_SETTING);
    }

    public function postUpdate(Setting $setting): void
    {
        $this->eventDispatcher->dispatch(new SettingsEvent($setting), SettingsEvent::POST_UPDATE_SETTING);
    }

    public function preRemove(Setting $setting): void
    {
        $this->eventDispatcher->dispatch(new SettingsEvent($setting), SettingsEvent::PRE_DELETE_SETTING);
    }

    public function postRemove(Setting $setting): void
    {
        $this->eventDispatcher->dispatch(new SettingsEvent($setting), SettingsEvent::POST_DELETE_SETTING);
    }
}
