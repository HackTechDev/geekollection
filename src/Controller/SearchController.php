<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchType;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;

class SearchController extends AbstractController
{

    #[Route('/search', name: 'app_search')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

      
        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $searchCriteria = $form->getData()['inputsearch'];
            
            $movieRepository = $entityManager->getRepository(Movie::class);
            $results = $movieRepository->findByTitle($searchCriteria);
            
            
            return $this->render('search/results.html.twig', [
                'results' => $results,
            ]);
        }


        return $this->render('search/index.html.twig', [
            'form' => $form,
        ]);
    }
}
