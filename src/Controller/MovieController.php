<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MediaRepository;
use App\Repository\SupportRepository;
use App\Repository\BoxRepository;
use App\Repository\EditionRepository;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Exception\ClientException;

#[Route('/movie')]
class MovieController extends AbstractController
{

    private $mediaRepository;
    private $supportRepository;
    private $boxRepository;
    private $editionRepository;


    public function __construct(MediaRepository $mediaRepository, SupportRepository $supportRepository, 
                                BoxRepository $boxRepository, EditionRepository $editionRepository)
    {
        $this->mediaRepository = $mediaRepository;
        $this->supportRepository = $supportRepository;
        $this->boxRepository = $boxRepository;
        $this->editionRepository = $editionRepository;
    }

    #[Route('/', name: 'app_movie_index', methods: ['GET'])]
    public function index(MovieRepository $movieRepository): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_movie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movie();

        $mediaChoices = $this->mediaRepository->findAll();
        $supportChoices = $this->supportRepository->findAll();
        $boxChoices = $this->boxRepository->findAll();
        $editionChoices = $this->editionRepository->findAll();

        // Create an array of choices with labels
        $mediaChoicesWithLabels = $this->getChoicesWithLabels($mediaChoices, 'label');
        $supportChoicesWithLabels = $this->getChoicesWithLabels($supportChoices, 'label');
        $boxChoicesWithLabels = $this->getChoicesWithLabels($boxChoices, 'label');
        $editionChoicesWithLabels = $this->getChoicesWithLabels($editionChoices, 'label');
        
        $form = $this->createForm(MovieType::class, $movie, [
            'media_choices' => $mediaChoicesWithLabels,
            'support_choices' => $supportChoicesWithLabels,
            'box_choices' => $boxChoicesWithLabels,
            'edition_choices' => $editionChoicesWithLabels,
        ]);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($movie->getMedia());
            $entityManager->persist($movie->getSupport());
            $entityManager->persist($movie->getBox());
            $entityManager->persist($movie->getEdition()); 

            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie/new.html.twig', [
            'movie' => $movie,
            'objectLinkData' => "na",
            'oeuvreLinkData' => "na",
            'form' => $form->createView(),
        ]);
    }


    private function getChoicesWithLabels($entities, $labelProperty)
    {
        $choices = [];
        foreach ($entities as $entity) {
            $choices[$entity->$labelProperty] = $entity; 
        }

        return $choices;
    }

  
    #[Route('/{id}', name: 'app_movie_show', methods: ['GET'])]
    public function show(Movie $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        
        $website = $request->query->get('website');
        $selectedId = $request->query->get('selectedId');
        $from = $request->query->get('from');

        // TODO: Optimize this piece of if code
        if ($from == 'object') {
            if ($website == null && $selectedId == null) {
                $objectLinkData = "na";
            } else {
                $objectLinkData = $website . ":" . $selectedId;
            }

            if( ($movie->getObjectlink() == "na" || $movie->getObjectlink() == ":") && $objectLinkData != "") {
                $objectLinkData = $objectLinkData;
            } else { 
                $objectLinkData = $movie->getObjectlink();
            }
        }

        if ($from == 'oeuvre') {
            if ($website == null && $selectedId == null) {
                $oeuvreLinkData = "na";
            } else {
                $oeuvreLinkData = $website . ":" . $selectedId;
            }

            if( ($movie->getOeuvrelink() == "na" || $movie->getOeuvrelink() == ":") && $oeuvreLinkData != "") {
                $oeuvreLinkData = $oeuvreLinkData;
            } else { 
                $oeuvreLinkData = $movie->getOeuvrelink();
            }
        }

        $mediaChoices = $this->mediaRepository->findAll();
        $supportChoices = $this->supportRepository->findAll();
        $boxChoices = $this->boxRepository->findAll();
        $editionChoices = $this->editionRepository->findAll();

        $form = $this->createForm(MovieType::class, $movie, [
            'media_choices' => $mediaChoices,
            'support_choices' => $supportChoices,
            'box_choices' => $boxChoices,
            'edition_choices' => $editionChoices,
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($movie->getMedia()); 
            $entityManager->persist($movie->getSupport());
            $entityManager->persist($movie->getBox()); 
            $entityManager->persist($movie->getEdition());
            
            // Then persist the Movie entity
            $entityManager->persist($movie);

            $entityManager->flush();

            return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($from == 'object') {
            return $this->render('movie/edit.html.twig', [
                'movie' => $movie,
                'form' => $form,
                'objectLinkData' => $objectLinkData,
                'oeuvreLinkData' => $movie->getOeuvrelink()
            ]);
        }

        if ($from == 'oeuvre') {
            return $this->render('movie/edit.html.twig', [
                'movie' => $movie,
                'form' => $form,
                'objectLinkData' => $movie->getObjectlink(),
                'oeuvreLinkData' => $oeuvreLinkData
            ]);
        }

        return $this->render('movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
            'objectLinkData' => $movie->getObjectlink(),
            'oeuvreLinkData' => $movie->getOeuvrelink()
        ]);
    }

    #[Route('/{id}', name: 'app_movie_delete', methods: ['POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    public function delete(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($movie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}/oeuvre', name: 'call_api_oeuvre', methods: ['POST'])]
    public function call_api_oeuvre(Request $request, Movie $movie, EntityManagerInterface $entityManager, HttpClientInterface $httpClient): Response
    {
        $movieId = $movie->getId();

        // TODO: Add antidoublon function
        // Search in the local database the searching movie
        // If not existing then call the API

        $apiUrlSearch = 'https://api.themoviedb.org/3/search/movie?query="' . urlencode($movie->getTitle()) . '"&include_adult=false&language=en-US&page=1';
        $header = [
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMTQzMDE4ZDVmNjU5MDQ2MjYzOWZhZjc3ZTMwYzhiYiIsInN1YiI6IjYwYzA3MmJiMzlhNDVkMDAyOWJlYmIwNSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.Y0_gHkSz_QQwG7-4xTi3OXL0y1cQdA7b8nHr1E8hqQQ',
            'accept' => 'application/json',
        ];
        
        $httpClient = HttpClient::create();

        try {
            $response = $httpClient->request('GET', $apiUrlSearch, [
                'headers' => $header,
            ]);
    
            if ($response->getStatusCode() === 200) {
                $jsonResponse = $response->getContent();
    
                $listData = json_decode($jsonResponse, true);

                return $this->render('movie/listoeuvre.html.twig', [
                    'movieId' => $movieId,
                    'listData' => $listData,
                ]);
                

            } else {
                return new Response('Error parsing JSON', 500);
            }
        } catch (ClientException $e) {
            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }


        return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit-oeuvrelink', name: 'edit_oeuvrelink', methods: ['POST'])]
    public function edit_oeuvrelink(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        $website = "themoviedb";
        $selectedId = $request->request->get('selectedData');
        $movieId = $request->request->get('movieId');
        $from = 'oeuvre';

        return $this->redirectToRoute('app_movie_edit', ['id' => $movieId, 'from' => $from, 'website' => $website, 'selectedId' => $selectedId], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/object', name: 'call_api_object', methods: ['POST'])]
    public function call_api_object(Request $request, Movie $movie, EntityManagerInterface $entityManager, HttpClientInterface $httpClient): Response
    {
     
        $movieId = $movie->getId();

        // TODO: Add antidoublon function
        // Search in the local database the searching movie
        // If not existing then call the API


        if ($movie->getTitle() != "" && $movie->getGencode() == "na") {
            $apiUrlSearch = "https://www.dvdfr.com/api/search.php?title='" . urlencode($movie->getTitle()) . "'";
        }

        if ( $movie->getTitle() != "" && $movie->getGencode() != "na") {
            $apiUrlSearch = "https://www.dvdfr.com/api/search.php?gencode=" . urlencode($movie->getGencode());
        }

        $gencode = $movie->getGencode();
        
        try {
            $response = $httpClient->request('GET', $apiUrlSearch);
            $content = $response->getContent();

            $xml = new \SimpleXMLElement($content);
            
            if ($xml) {
                foreach ($xml->dvd as $dvd) {
                    $id = (int)$dvd->id;
                    $cover = (string)$dvd->cover;
                    $title = (string)$dvd->titres->fr;

                    $listData[] = [
                        'id' => $id,
                        'cover' => $cover,
                        'title' => $title,
                        'gencode' => $gencode,
                    ];
                }
              
                return $this->render('movie/listobject.html.twig', [
                    'movieId' => $movieId,
                    'listData' => $listData,
                ]);
            } else {
                return new Response('Error parsing XML', 500);
            }
        } catch (\Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }

        return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit-objectlink', name: 'edit_objectlink', methods: ['POST'])]
    public function edit_objectlink(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        $website = "dvdfr";
        $selectedId = $request->request->get('selectedData');
        $movieId = $request->request->get('movieId');
        $from = "object";

        return $this->redirectToRoute('app_movie_edit', ['id' => $movieId, 'from' => $from, 'website' => $website, 'selectedId' => $selectedId], Response::HTTP_SEE_OTHER);
    }

}
