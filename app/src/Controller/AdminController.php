<?php

namespace App\Controller;

use App\Form\Type\ChangeEmailType;
use App\Form\Type\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminController extends AbstractController
{
    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;
    /**
     * Entity Manager.
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(TranslatorInterface $translator, EntityManagerInterface $entityManager)
    {
        $this->translator = $translator;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin_panel')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordEncoder): \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        $user = $this->getUser();

        $changePasswordForm = $this->createForm(ChangePasswordType::class, null, [
            'current_password_required' => true,
        ]);

        $changePasswordForm->handleRequest($request);
        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $data = $changePasswordForm->getData();

            if (!$passwordEncoder->isPasswordValid($user, $data['currentPassword'])) {
                $this->addFlash('danger', $this->translator->trans('message.incorrect.password'));
                return $this->redirectToRoute('admin_panel');
            }

            $newEncodedPassword = $passwordEncoder->hashPassword($user, $data['newPassword']);
            $user->setPassword($newEncodedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('password.changed'));

            return $this->redirectToRoute('admin_panel');
        }

        $changeEmailForm = $this->createForm(ChangeEmailType::class);

        $changeEmailForm->handleRequest($request);
        if ($changeEmailForm->isSubmitted() && $changeEmailForm->isValid()) {
            $data = $changeEmailForm->getData();

            if (!$passwordEncoder->isPasswordValid($user, $data['currentPassword'])) {
                $this->addFlash('danger', $this->translator->trans('message.incorrect.password'));
                return $this->redirectToRoute('admin_panel');
            }

            $user->setEmail($data['newEmail']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('email.changed'));

            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('admin/index.html.twig', [
            'changePasswordForm' => $changePasswordForm->createView(),
            'changeEmailForm' => $changeEmailForm->createView(),
        ]);
    }
}
