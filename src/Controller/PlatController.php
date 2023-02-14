<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/plat")
 * @IsGranted("ROLE_RESTAURATEUR")
 */
class PlatController extends AbstractController
{
    /**
     * @Route("/", name="app_plat")
     */
    public function index(PlatRepository $plat): Response
    {
        return $this->render('plat/index.html.twig', [
            'plats' => $plat->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_plat_view")
     */
    public function view(int $id,PlatRepository $plat): Response
    {
        return $this->render('plat/view.html.twig', [
            'plat' => $plat->find($id),
        ]);
    }

    /**
     * @Route("/add/{idResto}", name="app_plat_add")
     */
    public function add(int $idResto, Request $request, RestaurantRepository $restaurantRepository, ManagerRegistry $doctrine): Response
    {
        $plat = new Plat();

        $form = $this->createForm(PlatType::class, $plat);
        $manager = $doctrine->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plat = $form->getData();

            $restaurant = $restaurantRepository->find($idResto);
            $plat->setFkRestaurant($restaurant);

            $manager->persist($plat);
            $manager->flush();

            return $this->redirectToRoute('app_plat');
        }

        return $this->render('plat/add.html.twig', [
            'platForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_plat_edit")
     */
    public function edit(Request $request, PlatRepository $platRepository, Plat $plat): Response
    {
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $platRepository->add($plat,true);

            return $this->redirectToRoute('app_plat_view',["id"=>$plat->getId()]);
        }

        return $this->render('plat/edit.html.twig', [
            'platForm' => $form->createView(),
        ]);
    }
}
