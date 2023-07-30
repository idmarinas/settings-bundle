<?php

/**
 * This file is part of Legend of the Green Dragon.
 *
 * @see https://github.com/idmarinas/lotgd-game
 *
 * @license https://github.com/idmarinas/lotgd-game/blob/master/LICENSE.txt
 * @author IDMarinas
 *
 * @since 6.0.0
 */

namespace Idm\Bundle\Settings\Twig\Extension;

use Idm\Bundle\Settings\Repository\SettingRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SettingsExtension extends AbstractExtension
{
    public function __construct(
        private readonly SettingRepository $repository
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('setting_get_object', [$this->repository, 'getSettingObject']),
            new TwigFunction('setting_get', [$this->repository, 'getSetting']),
            new TwigFunction('setting_get_by_domain', [$this->repository, 'getSettingByDomain']),
        ];
    }
}
