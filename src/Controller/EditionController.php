<?php

namespace App\Controller;

use App\Entity\Edition;
use App\Form\EditionType;
use App\Repository\EditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/edition')]
class EditionController extends AbstractController
{
    #[Route('/', name: 'app_edition_index', methods: ['GET'])]
    public function index(EditionRepository $editionRepository): Response
    {
        return $this->render('edition/index.html.twig', [
            'editions' => $editionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_edition_new', methods: ['GET', 'POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $edition = new Edition();
        $form = $this->createForm(EditionType::class, $edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($edition);
            $entityManager->flush();

            return $this->redirectToRoute('app_edition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('edition/new.html.twig', [
            'edition' => $edition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_edition_show', methods: ['GET'])]
    public function show(Edition $edition): Response
    {
        return $this->render('edition/show.html.twig', [
            'edition' => $edition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_edition_edit', methods: ['GET', 'POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    public function edit(Request $request, Edition $edition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditionType::class, $edition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_edition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('edition/edit.html.twig', [
            'edition' => $edition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_edition_delete', methods: ['POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    public function delete(Request $request, Edition $edition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$edition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($edition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_edition_index', [], Response::HTTP_SEE_OTHER);
    }
}
