<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\Plat;
use App\Entity\Restaurant;
use App\Repository\CommandeRepository;
use App\Repository\DetailCommandeRepository;
use App\Repository\PlatRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/panier")
 * @IsGranted("ROLE_CLIENT")
 */

class PanierController extends AbstractController
{


    /**
     * @Route("/", name="app_panier")
     */
    public function viewPanier(
        SessionInterface $session,
        PlatRepository $platRepository
    ): Response {

        $tarifLivraison = 3;
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $plat = $platRepository->find($id);
            $dataPanier[] = [
                "plat" => $plat,
                "quantite" => $quantite
            ];
            $total += $plat->getTarif() * floatval($quantite);
        }

        return $this->render('panier/index.html.twig', [
            'dataPanier' => $dataPanier,
            'total' => $total + $tarifLivraison
        ]);
    }


    /**
     * @Route("/add/{id}/{page}", name="app_panier_add")
     */
    public function addPanier(int $id, int $page, SessionInterface $session, PlatRepository $platRepository): Response
    {
        $panier = $session->get("panier", []);

        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set("panier", $panier);
        $restaurant = $platRepository->find($id)->getFkRestaurant();

        if ($page == 1) {
            return $this->render('client/view-resto.html.twig', [
                'plats' => $platRepository->findPlat($restaurant->getId()),
            ]);
        }
        return $this->redirectToRoute('app_panier');
    }

    /**
     * @Route("/remove/{id}", name="app_panier_remove")
     */
    public function remove(Plat $plat, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $plat->getId();

        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier");
    }

    /**
     * @Route("/delete/{id}", name="app_panier_delete")
     */
    public function delete(Plat $plat, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $plat->getId();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier");
    }

    /**
     * @Route("/delete", name="app_panier_delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("app_panier");
    }

    /**
     * @Route("/confirm", name="app_panier_confirm")
     */
    public function confirm(
        SessionInterface $session,
        CommandeRepository $commandeRepository,
        DetailCommandeRepository $detailCommandeRepository,
        StatusRepository $statusRepository,
        PlatRepository $platRepository
    ) {
        $panier = $session->get("panier", []);

        $commande = new Commande();
        $time = new \DateTime();
        $commande->setDate($time);
        $commande->setDestination($this->getUser()->getPersonne()->getAdresse());

        $commande->setFkClient($this->getUser()->getPersonne());
        $commande->setFkStatus($statusRepository->find(1));
        $commandeRepository->add($commande, true);

        foreach ($panier as $id => $quantite) {
            $plat = $platRepository->find($id);
            $detailCommande = new DetailCommande();
            $detailCommande->setFkPlat($plat);
            $detailCommande->setQuantite($quantite);
            $detailCommande->setFkCommande($commande);
            $detailCommandeRepository->add($detailCommande,true);
        }

        return $this->render("panier/reussi.html.twig");
    }
}
