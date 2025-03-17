<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 16/03/2025, 23:17
 *
 * @project IDMarinas Settings Bundle
 * @see     https://github.com/idmarinas/settings-bundle
 *
 * @file    UserFactory.php
 * @date    17/03/2025
 * @time    15:43
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Factory\User;

use App\Entity\User\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
	public function __construct (private readonly UserPasswordHasherInterface $hasher)
	{
		parent::__construct();
	}

	public static function class (): string
	{
		return User::class;
	}

	/**
	 * @see  https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
	 */
	protected function defaults (): array|callable
	{
		$createdAt = self::faker()->dateTime('-1 year');
		$updatedAt = self::faker()->dateTimeBetween($createdAt, '-1 day');

		return [
			'email'           => self::faker()->unique()->email(),
			'displayName'     => self::faker()->unique()->userName(),
			'sessionId'       => self::faker()->sha1(),
			'createdFromIp'   => self::faker()->ipv4(),
			'updatedFromIp'   => self::faker()->ipv4(),
			'lastConnection'  => self::faker()->dateTimeBetween($createdAt, $updatedAt),
			'createdAt'       => $createdAt,
			'updatedAt'       => $updatedAt,
			'bannedUntil'     => self::faker()->dateTimeBetween('now', '+3 years'),
			'deletedAt'       => self::faker()->dateTimeBetween($createdAt),
			'privacyAccepted' => self::faker()->boolean(),
			'termsAccepted'   => self::faker()->boolean(),
			'verified'        => self::faker()->boolean(),
		];
	}

	/**
	 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
	 */
	protected function initialize (): static
	{
		return parent::initialize()
			->afterInstantiate(function (User $user): void {
				$user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
			})
		;
	}
}
