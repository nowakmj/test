<?php

/**
 * User service interface.
 */

namespace App\Service;

use App\Entity\User;

/**
 * Interface UserServiceInterface.
 */
interface UserServiceInterface
{
    /**
     * Saves a user.
     *
     * @param User $user  the user to save
     * @param bool $flush whether to flush changes to the database
     */
    public function save(User $user, bool $flush = false): void;

    /**
     * Removes a user.
     *
     * @param User $user  the user to remove
     * @param bool $flush whether to flush changes to the database
     */
    public function remove(User $user, bool $flush = false): void;

    /**
     * Upgrades a user's password.
     *
     * @param User   $user              the user whose password to upgrade
     * @param string $newHashedPassword the new hashed password
     */
    public function upgradePassword(User $user, string $newHashedPassword): void;
}
