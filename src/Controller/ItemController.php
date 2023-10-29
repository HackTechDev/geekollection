<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
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

#[Route('/item')]
class ItemController extends AbstractController
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

    #[Route('/', name: 'app_item_index', methods: ['GET'])]
    public function index(ItemRepository $itemRepository): Response
    {
        return $this->render('item/index.html.twig', [
            'items' => $itemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $item = new Item();

        $mediaChoices = $this->mediaRepository->findAll();
        $supportChoices = $this->supportRepository->findAll();
        $boxChoices = $this->boxRepository->findAll();
        $editionChoices = $this->editionRepository->findAll();

        // Create an array of choices with labels
        $mediaChoicesWithLabels = $this->getChoicesWithLabels($mediaChoices, 'label');
        $supportChoicesWithLabels = $this->getChoicesWithLabels($supportChoices, 'label');
        $boxChoicesWithLabels = $this->getChoicesWithLabels($boxChoices, 'label');
        $editionChoicesWithLabels = $this->getChoicesWithLabels($editionChoices, 'label');
        
        $form = $this->createForm(ItemType::class, $item, [
            'media_choices' => $mediaChoicesWithLabels,
            'support_choices' => $supportChoicesWithLabels,
            'box_choices' => $boxChoicesWithLabels,
            'edition_choices' => $editionChoicesWithLabels,
        ]);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($item->getMedia());
            $entityManager->persist($item->getSupport());
            $entityManager->persist($item->getBox());
            $entityManager->persist($item->getEdition()); 

            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item/new.html.twig', [
            'item' => $item,
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

  
    #[Route('/{id}', name: 'app_item_show', methods: ['GET'])]
    public function show(Item $item): Response
    {
        return $this->render('item/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        
        $mediaChoices = $this->mediaRepository->findAll();
        $supportChoices = $this->supportRepository->findAll();
        $boxChoices = $this->boxRepository->findAll();
        $editionChoices = $this->editionRepository->findAll();

        $form = $this->createForm(ItemType::class, $item, [
            'media_choices' => $mediaChoices,
            'support_choices' => $supportChoices,
            'box_choices' => $boxChoices,
            'edition_choices' => $editionChoices,
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($item->getMedia()); 
            $entityManager->persist($item->getSupport());
            $entityManager->persist($item->getBox()); 
            $entityManager->persist($item->getEdition());
            
            // Then persist the Item entity
            $entityManager->persist($item);

            $entityManager->flush();

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_item_delete', methods: ['POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    public function delete(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}/oeuvre', name: 'call_api_oeuvre', methods: ['POST'])]
    public function call_api_oeuvre(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        //die("call_api_oeuvre: " . $item->getTitle());
        return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/object', name: 'call_api_object', methods: ['POST'])]
    public function all_api_object(Request $request, Item $item, EntityManagerInterface $entityManager, HttpClientInterface $httpClient): Response
    {
        
        if ($item->getTitle() != "" && $item->getGencode() == "") {
            $apiUrlSearch = "https://www.dvdfr.com/api/search.php?title='" . urlencode($item->getTitle()) . "'";
        }

        if ( ($item->getTitle() == "" || $item->getTitle() != "") && $item->getGencode() != "") {
            $apiUrlSearch = "https://www.dvdfr.com/api/search.php?gencode=" . urlencode($item->getGencode());
        }

        $gencode = $item->getGencode();

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
                return $this->render('item/listobject.html.twig', [
                    'listData' => $listData,
                ]);
            } else {
                return new Response('Error parsing XML', 500);
            }
        } catch (\Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }

        return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
    }

}
