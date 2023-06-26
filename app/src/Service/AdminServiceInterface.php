<?php

/**
 * AdminServiceInterface.
 */

namespace App\Service;

use App\Entity\User;

/**
 * Interface AdminServiceInterface.
 */
interface AdminServiceInterface
{
    /**
     * Action update password.
     *
     * @param User   $admin       Admin user entity
     * @param string $newPassword New password
     */
    public function updatePassword(User $admin, string $newPassword): void;

    /**
     * Action update email.
     *
     * @param User   $admin    Admin user entity
     * @param string $newEmail New email
     */
    public function updateEmail(User $admin, string $newEmail): void;
}
