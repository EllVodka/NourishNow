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
        
        $commandes_prete = $commandeRepository->findBy(array('fk_status' => 3));
        return $this->render('livreur/index.html.twig', [
            'controller_name' => 'LivreurController',
            'commandes_prete' => $commandes_prete
        ]);
    }

    /**
     * @Route("/{id}", name="app_view_commande_take")
     * isGranted("ROLE_LIVREUR")
     */
     public function showCommande(int $id, CommandeRepository $commandeRepository): Response

     {
        $commande = $commandeRepository->findCommande($id);
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
