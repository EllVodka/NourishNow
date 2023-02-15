<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\Status;
use App\Form\CommandType;
use App\Repository\CommandeRepository;
use App\Repository\DetailCommandeRepository;
use App\Repository\StatusRepository;
use Doctrine\Persistence\ManagerRegistry;
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
     * @IsGranted("ROLE_RESTAURATEUR")
     */
    public function viewByRestoId(int $idResto, CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findCommandeByRestoId($idResto),
        ]);
    }

    /**
     * @Route("/{idResto<\d+>}/{id<\d+>}", name="app_commande_view")
     * @IsGranted("ROLE_RESTAURATEUR")
     */
    public function view(int $id, CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/view.html.twig', [
            'commande' => $commandeRepository->findCommande($id),
        ]);
    }

    /**
     * @Route("/update-status/{commande}", name="app_commande_update_status")
     * @IsGranted("ROLE_RESTAURATEUR")
     */
    public function updateStatus(Commande $commande,Request $request, CommandeRepository $commandeRepository): Response
    {
        $detailCommande = $commande->getDetailCommandes()[0];
        $form = $this->createForm(CommandType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->add($commande, true);

            return $this->redirectToRoute(
                'app_commande_view',
                [
                    "idResto" => $detailCommande->getFkPlat()->getFkRestaurant()->getId(),
                    "id" => $commande->getId(),
                ]
            );
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commandeForm' => $form,
        ]);
    }
}
