<?php

namespace App\Controller;

use App\Entity\Library;
use App\Form\LibraryType;
use App\Entity\Item;
use App\Repository\LibraryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/library')]
class LibraryController extends AbstractController
{
    
    private $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    
    }

    #[Route('/', name: 'app_library_index', methods: ['GET'])]
    public function index(LibraryRepository $libraryRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->findIdByEmail($this->getUser()->getUserIdentifier());

        $userId = $user->getId();
       
        

        $libraries =  $libraryRepository->findAllForUser($userId);

        return $this->render('library/index.html.twig', [
            'libraries' => $libraries,
            'userid' => $userId,
        ]);
    }

    #[Route('/new', name: 'app_library_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser(); // Get the connected user
        $library = new Library();
        $library->addUser($user); // Set the connected user in the Library entity
    
        $form = $this->createForm(LibraryType::class, $library);
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($library);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_library_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('library/new.html.twig', [
            'library' => $library,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_library_show', methods: ['GET'])]
    public function show(Library $library): Response
    {
        return $this->render('library/show.html.twig', [
            'library' => $library,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_library_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Library $library, EntityManagerInterface $entityManager, $id): Response
    {
        $library = $entityManager->getRepository(Library::class)->find($id);
        $item = $library->getItem();
        $titles = [];
        foreach ($library->getItem() as $item) {
            $titles[] = $item->getTitle();
        }

        $form = $this->createForm(LibraryType::class, $library);
        $form->handleRequest($request);

    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_library_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('library/edit.html.twig', [
            'library' => $library,
            'form' => $form,
            'title' => $titles[0]
        ]);
    }

    #[Route('/{id}', name: 'app_library_delete', methods: ['POST'])]
    public function delete(Request $request, Library $library, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$library->getId(), $request->request->get('_token'))) {
            $entityManager->remove($library);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_library_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/add-item-library', name: 'add_item_library', methods: ['POST'])]
    public function add_item_library(Request $request, Item $item, EntityManagerInterface $entityManager, Security $security): Response
    {
        
        $user = $security->getUser(); // Get the connected user
        $library = new Library();
        
        $library->addUser($user); // Set the connected user in the Library entity
        
        $selectedId = $request->request->get('selectedData');

        dd($selectedId);
        $item = $entityManager->getRepository(Item::class)->find($selectedId);
        $library->addItem($item);
  

        $form = $this->createForm(LibraryType::class, $library);
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager->persist($library);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_library_index', [], Response::HTTP_SEE_OTHER);
        }
      
        return $this->render('library/new.html.twig', [
            'library' => $library,
            'form' => $form,
        ]);

    }
}
