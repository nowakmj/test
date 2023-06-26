<?php

/**
 * AdminService.
 */

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AdminService.
 */
class AdminService implements AdminServiceInterface
{
    /**
     * Interface EntityManagerInterface.
     */
    private EntityManagerInterface $entityManager;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager EntityManager instance
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Action update password.
     *
     * @param User   $admin       User entity
     * @param string $newPassword New password
     */
    public function updatePassword(User $admin, string $newPassword): void
    {
        $encodedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $admin->setPassword($encodedPassword);

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }

    /**
     * Action update email.
     *
     * @param User   $admin    User entity
     * @param string $newEmail New email
     */
    public function updateEmail(User $admin, string $newEmail): void
    {
        $admin->setEmail($newEmail);

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }
}
