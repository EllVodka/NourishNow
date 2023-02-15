<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
            'restaurants' => $restaurantRepository->findBy(
                ["fk_ville" => $this->getUser()->getPersonne()->getFkVille()->getId()]
            ),
        ]);
    }
}
