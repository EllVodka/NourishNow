<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\PlatRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{

    /**
     * @Route("/", name="app_client")
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {

        return $this->render('client/index.html.twig', [
            'restaurants' => $restaurantRepository->findRestaurant(
                $this->getUser()->getPersonne()->getFkVille()->getId()
            ),
        ]);
    }

    /**
     * @Route("/{restaurant}", name="app_client_view_resto")
     */
    public function viewResto(Restaurant $restaurant, PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findPlat($restaurant->getId());

        return $this->render('client/view-resto.html.twig', [
            'plats' => $plats,
        ]);
    }
 
}
