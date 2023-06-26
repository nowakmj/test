<?php

/**
 * AdminRepository.
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AdminRepository.
 */
class AdminRepository
{
    /**
     * Interface EntityManagerInterface.
     *
     * @var EntityManagerInterface interface EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager The entity manager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Action update password.
     *
     * @param User   $admin       The admin user
     * @param string $newPassword The new password
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
     * @param User   $admin    The admin user
     * @param string $newEmail The new email
     */
    public function updateEmail(User $admin, string $newEmail): void
    {
        $admin->setEmail($newEmail);

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }
}
