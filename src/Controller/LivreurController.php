<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livreur")
 */
class LivreurController extends AbstractController
{
    /**
     * @Route("/", name="app_livreur")
     * isGranted("ROLE_LIVREUR")
     */
    public function index(CommandeRepository $commandeRepository): Response

    {
        $commandePrete = $commandeRepository->findCommandByStatusAndDate();
        return $this->render('livreur/index.html.twig', [
            'controller_name' => 'LivreurController',

            'commandes_prete' => $commandePrete

        ]);
    }

    /**
     * @Route("/{id}", name="app_view_commande_take")
     * isGranted("ROLE_LIVREUR")
     */
    public function showCommande(int $id, CommandeRepository $commandeRepository): Response

    {
        $idLivreur = $this->getUser()->getPersonne();
        $commande = $commandeRepository->findCommande($id);
        
        $commande[0]->setFkLivreur($idLivreur);
        $commandeRepository->add($commande[0], true);

        return $this->render('livreur/view.html.twig', [
            'commande' => $commande
        ]);
    }

    /**
     * @Route("/editstatus/{commande}", name="app_edit_commande_status")
     * isGranted("ROLE_LIVREUR")
     */
    public function editStatusCommande(Commande $commande, StatusRepository $statusRepository, CommandeRepository $commandeRepository): Response
    {
        $commande->setFkStatus($statusRepository->find(5));
        $commandeRepository->add($commande, true);

        return $this->redirectToRoute("app_livreur");
    }
}
