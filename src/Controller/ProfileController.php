<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/profile', name: 'app_profile')]
#[IsGranted('ROLE_USER')]
final class ProfileController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // 1) Gestion du mot de passe
                $newPlain = $form->get('plainPassword')->getData();
                if ($newPlain) {
                    $hashed = $this->passwordHasher->hashPassword($user, $newPlain);
                    $user->setPassword($hashed);
                }

                // 2) VichUploader gère avatarFile automatiquement

                $this->em->persist($user);
                $this->em->flush();

                $this->addFlash('success', 'Votre profil a bien été mis à jour.');

                return $this->redirectToRoute('app_profile');
            }

            // Gestion manuelle d’erreurs globales si besoin
            if ($form->get('avatarFile')->getErrors(true)->count() > 0) {
                $form->get('avatarFile')->addError(new FormError('Le fichier uploadé est invalide.'));
            }
        }

        return $this->render('profile/index.html.twig', [
            'profileForm' => $form->createView(),
            'user' => $user,
        ]);
    }
}
