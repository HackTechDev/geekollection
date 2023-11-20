<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Entity\Movie;
use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/item')]
class ItemController extends AbstractController
{
    
    private $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    
    }

    #[Route('/', name: 'app_item_index', methods: ['GET'])]
    public function index(ItemRepository $itemRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->findIdByEmail($this->getUser()->getUserIdentifier());

        $userId = $user->getId();
       
        

        $items =  $itemRepository->findAllForUser($userId);

        return $this->render('item/index.html.twig', [
            'items' => $items,
            'userid' => $userId,
        ]);
    }

    #[Route('/new', name: 'app_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser(); // Get the connected user
        $item = new Item();
        $item->addUser($user); // Set the connected user in the Item entity
    
        $form = $this->createForm(ItemType::class, $item);
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($item);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('item/new.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_item_show', methods: ['GET'])]
    public function show(Item $item): Response
    {
        return $this->render('item/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Item $item, EntityManagerInterface $entityManager, $id): Response
    {
        $item = $entityManager->getRepository(Item::class)->find($id);

        // Todo: review this method to get the title
        $movie = $item->getMovie();
        $titles = [];
        foreach ($item->getMovie() as $movie) {
            $titles[] = $movie->getTitle();
        }

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
            'title' => $titles[0]
        ]);
    }

    #[Route('/{id}', name: 'app_item_delete', methods: ['POST'])]
    public function delete(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/add-movie-item', name: 'add_movie_item', methods: ['POST'])]
    public function add_movie_item(Request $request, Movie $movie, EntityManagerInterface $entityManager, Security $security): Response
    {
        
        $user = $security->getUser(); // Get the connected user
        $item = new Item();
        
        $item->addUser($user); // Set the connected user in the Item entity
        
        $selectedId = $request->request->get('selectedData');
        
        if ($selectedId != null) {
            $movie = $entityManager->getRepository(Movie::class)->find($selectedId);
            $item->addMovie($movie);
            $item->setSelectedData($selectedId);

            // Todo: review this method to get the title
            $movie = $item->getMovie();
            $titles = [];
            foreach ($item->getMovie() as $movie) {
                $titles[] = $movie->getTitle();
            }
        }
        

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $entityManager->getRepository(Movie::class)->find($item->getSelectedData());
            $item->addMovie($movie);

            $entityManager->persist($item);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }
 
        return $this->render('item/new.html.twig', [
            'item' => $item,
            'form' => $form,
            'title' => $titles[0]
        ]);

    }
}
