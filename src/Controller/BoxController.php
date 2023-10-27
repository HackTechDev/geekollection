<?php

namespace App\Controller;

use App\Entity\Box;
use App\Form\BoxType;
use App\Repository\BoxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/box')]
class BoxController extends AbstractController
{
    #[Route('/', name: 'app_box_index', methods: ['GET'])]
    public function index(BoxRepository $boxRepository): Response
    {
        return $this->render('box/index.html.twig', [
            'boxes' => $boxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_box_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $box = new Box();
        $form = $this->createForm(BoxType::class, $box);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($box);
            $entityManager->flush();

            return $this->redirectToRoute('app_box_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('box/new.html.twig', [
            'box' => $box,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_box_show', methods: ['GET'])]
    public function show(Box $box): Response
    {
        return $this->render('box/show.html.twig', [
            'box' => $box,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_box_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Box $box, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BoxType::class, $box);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_box_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('box/edit.html.twig', [
            'box' => $box,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_box_delete', methods: ['POST'])]
    public function delete(Request $request, Box $box, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$box->getId(), $request->request->get('_token'))) {
            $entityManager->remove($box);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_box_index', [], Response::HTTP_SEE_OTHER);
    }
}
