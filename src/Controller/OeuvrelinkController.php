<?php

namespace App\Controller;

use App\Entity\Oeuvrelink;
use App\Form\OeuvrelinkType;
use App\Repository\OeuvrelinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/oeuvrelink')]
class OeuvrelinkController extends AbstractController
{
    #[Route('/', name: 'app_oeuvrelink_index', methods: ['GET'])]
    public function index(OeuvrelinkRepository $oeuvrelinkRepository): Response
    {
        return $this->render('oeuvrelink/index.html.twig', [
            'oeuvrelinks' => $oeuvrelinkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_oeuvrelink_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $oeuvrelink = new Oeuvrelink();
        $form = $this->createForm(OeuvrelinkType::class, $oeuvrelink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($oeuvrelink);
            $entityManager->flush();

            return $this->redirectToRoute('app_oeuvrelink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('oeuvrelink/new.html.twig', [
            'oeuvrelink' => $oeuvrelink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_oeuvrelink_show', methods: ['GET'])]
    public function show(Oeuvrelink $oeuvrelink): Response
    {
        return $this->render('oeuvrelink/show.html.twig', [
            'oeuvrelink' => $oeuvrelink,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_oeuvrelink_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Oeuvrelink $oeuvrelink, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OeuvrelinkType::class, $oeuvrelink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_oeuvrelink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('oeuvrelink/edit.html.twig', [
            'oeuvrelink' => $oeuvrelink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_oeuvrelink_delete', methods: ['POST'])]
    public function delete(Request $request, Oeuvrelink $oeuvrelink, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oeuvrelink->getId(), $request->request->get('_token'))) {
            $entityManager->remove($oeuvrelink);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_oeuvrelink_index', [], Response::HTTP_SEE_OTHER);
    }
}
