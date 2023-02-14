<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Repository\DetailCommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/{idResto}", name="app_commande")
     */
    public function viewByRestoId(int $idResto, DetailCommandeRepository $detailCommandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $detailCommandeRepository->findCommandeByRestoId($idResto),
        ]);
    }

    /**
     * @Route("/{idResto}/{id}", name="app_commande")
     */
    public function view(int $id, DetailCommandeRepository $detailCommandeRepository): Response
    {
        return $this->render('commande/view.html.twig', [
            'commande' => $detailCommandeRepository->findCommande($id),
        ]);
    }

}
