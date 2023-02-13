<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationPersonneType;
use App\Repository\UserRepository;
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
                    "idUser" => $user->getId()
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
     * @Route("/registerPersonne/{idUser}", name="app_register_personne")
     */
    public function registerPersonne(int $idUser, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($idUser);
        $personne = new Personne();
        $personne->setEmail($user->getEmail());
        $form = $this->createForm(RegistrationPersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($personne);
            $entityManager->flush();



            dump($personne);
            return $this->redirectToRoute('_profiler_home');
        }

        return $this->render(
            'registration/registerPersonne.html.twig',
            [
                'formPersonne' => $form->createView(),
            ]
        );
    }
}
