<?php

namespace App\Controller;

use App\Dto\filter;
use App\Entity\Competence;
use App\Entity\User;
use App\Form\FilterCompetencesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilterCompetencesController extends AbstractController
{
    /**
     * @Route("/filter/competences", name="filter_competences")
     */
    public function index(Request $request): Response
    {
        $search = new filter();
        $form = $this->createForm(FilterCompetencesType::class, $search);

        $form->handleRequest($request);
        dump($request);

        $result = $this->getDoctrine()->getRepository(User::class)->findAll();

        if($form->isSubmitted())
        {
            // dd($result);
            $result = $this->getDoctrine()->getRepository(User::class)->findSearchAll($search);
            // dd($search);
            dd($result);
        }

        return $this->render('filter_competences/filter.html.twig', [
            'form'      => $form->createView(),
            'result'    => $result
        ]);
    }
}
