<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurateurType;
use App\Repository\PersonneRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/restaurateur",)
 * @IsGranted("ROLE_RESTAURATEUR")
 */
class RestaurateurController extends AbstractController
{
    /**
     * @Route("/", name="app_restaurateur")
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        $id = $this->getUser()->getPersonne()->getId();
        $restaurants = $restaurantRepository->findBy(array('fk_personne' => $id));
        
        return $this->render('restaurateur/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * @Route("/add", name="app_restaurateur_add")
     */
    public function add(PersonneRepository $personneRepository, ManagerRegistry $doctrine, Request $request): Response
    {
        $restaurant = new Restaurant();

        $form = $this->createForm(RestaurateurType::class, $restaurant);
        $manager = $doctrine->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = $form->getData();

            $personne = $personneRepository->find($this->getUser());
            $restaurant->setFkPersonne($personne);

            $manager->persist($restaurant);
            $manager->flush();

            return $this->redirectToRoute('app_restaurateur');
        }

        return $this->render('restaurateur/add.html.twig', [
            'formRestaurant' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_restaurateur_edit")
     */
    public function edit(Request $request, Restaurant $restaurant, RestaurantRepository $restaurantRepository): Response
    {
        $form = $this->createForm(RestaurateurType::class, $restaurant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $restaurantRepository->add($restaurant,true);

            return $this->redirectToRoute('app_restaurateur_view',["id"=>$restaurant->getId()]);
        }

        return $this->render('restaurateur/edit.html.twig', [
            'formRestaurant' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurateur_view")
     */
    public function view(int $id,RestaurantRepository $restaurantRepository): Response
    {
        $restaurant = $restaurantRepository->find($id);
        return $this->render('restaurateur/view.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }
}
