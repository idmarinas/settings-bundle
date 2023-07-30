<?php

/**
 * This file is part of Legend of the Green Dragon.
 *
 * @see https://github.com/idmarinas/lotgd-game
 *
 * @license https://github.com/idmarinas/lotgd-game/blob/master/LICENSE.txt
 *
 * @since 6.0.0
 */

namespace Idm\Bundle\Settings\EventSubscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Idm\Bundle\Settings\Event\SettingsEvent;
use Idm\Bundle\Settings\IdmSettingCache;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SettingsSubscriber implements EventSubscriberInterface
{
    protected $cache;

    public function __construct(CacheItemPoolInterface $lotgdBundlePackageCache)
    {
        $this->cache = $lotgdBundlePackageCache;
    }

    public function onCreateSetting(SettingsEvent $event)
    {
        $setting = $event->getSetting();

        $item = $this->cache->getItem(IdmSettingCache::COLLECTION);
        /** @var ArrayCollection */
        $collection = $item->get();

        if ( ! $collection) {
            return;
        }

        $collection->add($setting);

        $item->set($collection);
        $this->cache->save($item);
    }

    public function onDeleteSetting(SettingsEvent $event)
    {
        $setting = $event->getSetting();

        $item = $this->cache->getItem(IdmSettingCache::COLLECTION);
        /** @var ArrayCollection */
        $collection = $item->get();

        if ( ! $collection) {
            return;
        }

        $collection->removeElement($setting);

        $item->set($collection);
        $this->cache->save($item);
    }

    public function onUpdateSetting(SettingsEvent $event)
    {
        $setting = $event->getSetting();

        $item = $this->cache->getItem(IdmSettingCache::COLLECTION);
        /** @var ArrayCollection */
        $collection = $item->get();

        if ( ! $collection) {
            return;
        }

        if ($collection->contains($setting)) {
            $index = $collection->indexOf($setting);

            $collection->set($index, $setting);
        }

        $item->set($collection);
        $this->cache->save($item);
    }

    /**
     * @return array<string, mixed>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SettingsEvent::POST_CREATE_SETTING => 'onCreateSetting',
            SettingsEvent::POST_DELETE_SETTING => 'onDeleteSetting',
            SettingsEvent::POST_UPDATE_SETTING => 'onUpdateSetting',
        ];
    }
}
