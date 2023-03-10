<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\Ville;
use App\Repository\CommandeRepository;
use App\Repository\EvaluationRepository;
use App\Repository\PersonneRepository;
use App\Repository\PlatRepository;
use App\Repository\RestaurantRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{

    /**
     * @Route("/", name="app_client")
     */
    public function index(RestaurantRepository $restaurantRepository, VilleRepository $villeRepository, EvaluationRepository $evaluationRepository): Response
    {
        $restaurants = new Restaurant();

        if ($this->getUser() == null) {
            $restaurants = $restaurantRepository->findAll();
        } else {
            $restaurants = $restaurantRepository->findRestaurantInSecteur(
                $this->getUser()->getPersonne()->getFkVille()->getFkSecteur()->getId()
            );
        }

        return $this->render('client/index.html.twig', [
            'restaurants' => $restaurants,
            'villes' => $villeRepository->findAll(),
            'eval' => $evaluationRepository->findBy([
                'fk_client' => $this->getUser()->getPersonne()
            ]),
        ]);
    }
    /**
     * @Route("/ville/{ville<\d+>}", name="app_client_ville")
     */
    public function indexVille(Ville $ville, RestaurantRepository $restaurantRepository, VilleRepository $villeRepository): Response
    {
        $restaurants = $restaurantRepository->findRestaurant($ville->getId());
        return $this->render('client/index.html.twig', [
            'restaurants' => $restaurants,
            'villes' => $villeRepository->findAll()
        ]);
    }

    /**
     * @Route("/{restaurant<\d+>}", name="app_client_view_resto")
     */
    public function viewResto(Restaurant $restaurant, PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findPlat($restaurant->getId());

        return $this->render('client/view-resto.html.twig', [
            'plats' => $plats,
        ]);
    }

    /**
     * @Route("/suivi", name="app_client_view_suivi_commande")
     */
    public function viewSuiviCommande(CommandeRepository $commandeRepository): Response
    {
        $id = $this->getUser()->getPersonne()->getId();
        $commande = $commandeRepository->findAllCommandByClientId($id);
        return $this->render('client/suivi.html.twig', [
            'commande' => $commande
        ]);
    }
}
