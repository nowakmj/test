<?php

/**
 * User Service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository the user repository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Saves a user.
     *
     * @param User $user  the user to save
     * @param bool $flush whether to flush changes to the database
     */
    public function save(User $user, bool $flush = false): void
    {
        $this->userRepository->save($user, $flush);
    }

    /**
     * Removes a user.
     *
     * @param User $user  the user to remove
     * @param bool $flush whether to flush changes to the database
     */
    public function remove(User $user, bool $flush = false): void
    {
        $this->userRepository->remove($user, $flush);
    }

    /**
     * Upgrades a user's password.
     *
     * @param User   $user              the user whose password to upgrade
     * @param string $newHashedPassword the new hashed password
     */
    public function upgradePassword(User $user, string $newHashedPassword): void
    {
        $user->setPassword($newHashedPassword);
        $this->userRepository->save($user, true);
    }
}
