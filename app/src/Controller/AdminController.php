<?php

namespace App\Controller;

use App\Form\Type\ChangePasswordType;
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

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/admin', name: 'admin_panel')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordEncoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, null, [
            'current_password_required' => true,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if (!$passwordEncoder->isPasswordValid($user, $data['currentPassword'])) {
                $this->addFlash('error', $this->translator->trans('message.incorrect.password'));
                return $this->redirectToRoute('admin_panel');
            }

            $newEncodedPassword = $passwordEncoder->hashPassword($user, $data['newPassword']);
            $user->setPassword($newEncodedPassword);
            $user->setEmail($data['email']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans('password.changed'));

            return $this->redirectToRoute('notice_index');
        }

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
