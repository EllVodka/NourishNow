<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationPersonneType;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute(
                'app_register_personne',
                [
                    "user" => $user->getId()
                ]
            );
        }

        return $this->render(
            'registration/register.html.twig',
            [
                'registrationForm' => $form->createView(),
            ]
        );
    }
    /**
     * @Route("/registerPersonne/{user}", name="app_register_personne")
     */
    public function registerPersonne(User $user, Request $request, VilleRepository $villeRepository, EntityManagerInterface $entityManager): Response
    {
        $ville = $villeRepository->findAll();
        $personne = new Personne();
        $personne->setEmail($user->getEmail());
        $form = $this->createForm(RegistrationPersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personne->setFkUser($user);

            if ($form->get('role')->getData() == "Client") {
                $personne->getFkUser()->setRoles(['ROLE_CLIENT']);
            } else if ($form->get('role')->getData() == "Livreur") {
                $personne->getFkUser()->setRoles(["ROLE_LIVREUR"]);
            } else if ($form->get('role')->getData() == "Restaurateur") {
                $personne->getFkUser()->setRoles(["ROLE_RESTAURATEUR"]);
            } else {
                $personne->getFkUser()->setRoles(['ROLE_CLIENT']);
            }

            $entityManager->persist($personne);
            $entityManager->flush();



            dump($personne);
            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'registration/registerPersonne.html.twig',
            [
                'formPersonne' => $form->createView(),
            ]
        );
    }
}
