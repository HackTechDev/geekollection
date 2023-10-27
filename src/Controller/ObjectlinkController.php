<?php

namespace App\Controller;

use App\Entity\Objectlink;
use App\Form\ObjectlinkType;
use App\Repository\ObjectlinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/objectlink')]
class ObjectlinkController extends AbstractController
{
    #[Route('/', name: 'app_objectlink_index', methods: ['GET'])]
    public function index(ObjectlinkRepository $objectlinkRepository): Response
    {
        return $this->render('objectlink/index.html.twig', [
            'objectlinks' => $objectlinkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_objectlink_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $objectlink = new Objectlink();
        $form = $this->createForm(ObjectlinkType::class, $objectlink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($objectlink);
            $entityManager->flush();

            return $this->redirectToRoute('app_objectlink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('objectlink/new.html.twig', [
            'objectlink' => $objectlink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objectlink_show', methods: ['GET'])]
    public function show(Objectlink $objectlink): Response
    {
        return $this->render('objectlink/show.html.twig', [
            'objectlink' => $objectlink,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_objectlink_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Objectlink $objectlink, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ObjectlinkType::class, $objectlink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_objectlink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('objectlink/edit.html.twig', [
            'objectlink' => $objectlink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objectlink_delete', methods: ['POST'])]
    public function delete(Request $request, Objectlink $objectlink, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objectlink->getId(), $request->request->get('_token'))) {
            $entityManager->remove($objectlink);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_objectlink_index', [], Response::HTTP_SEE_OTHER);
    }
}
