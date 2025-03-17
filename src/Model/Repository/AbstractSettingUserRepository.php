<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 16/03/2025, 19:02
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    AbstractSettingUserRepository.php
 * @date    16/03/2025
 * @time    19:02
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\Settings\Model\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Idm\Bundle\Settings\Model\Entity\AbstractSetting;

/**
 * @extends ServiceEntityRepository<AbstractSetting>
 */
abstract class AbstractSettingUserRepository extends ServiceEntityRepository {}
