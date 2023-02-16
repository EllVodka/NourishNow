<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\Restaurant;
use App\Form\EvaluationType;
use App\Repository\EvaluationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/evaluation", name="app_evaluation")
 * @IsGranted("ROLE_CLIENT")
 */
class EvaluationController extends AbstractController
{

    /**
     * @Route("/{restaurant}", name="_eval")
     */
    public function index(Restaurant $restaurant, Request $request, EvaluationRepository $evaluationRepository, ManagerRegistry $doctrine): Response
    {
        $evaluation = new Evaluation();

        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evaluation = $form->getData();
            $evaluation->setFkClient($this->getUser()->getPersonne());
            $evaluation->setFkRestaurant($restaurant);
    
            $evaluationRepository->add($evaluation, true);
    
            return $this->redirectToRoute('app_client');
        }
        return $this->renderForm('evaluation/index.html.twig',[
            'evalForm'=> $form
        ]);
    }
}
