<?php

namespace App\Controller;

use App\Entity\Notation;
use App\Form\NotationType;
use App\Repository\NotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notation")
 */
class NotationController extends AbstractController
{
    /**
     * @Route("/", name="notation_index", methods={"GET"})
     */
    public function index(NotationRepository $notationRepository): Response
    {
        return $this->render('notation/index.html.twig', [
            'notations' => $notationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="notation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $notation = new Notation();
        $form = $this->createForm(NotationType::class, $notation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notation);
            $entityManager->flush();

            return $this->redirectToRoute('notation_index');
        }

        return $this->render('notation/new.html.twig', [
            'notation' => $notation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="notation_show", methods={"GET"})
     */
    public function show(Notation $notation): Response
    {
        return $this->render('notation/show.html.twig', [
            'notation' => $notation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="notation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Notation $notation): Response
    {
        $form = $this->createForm(NotationType::class, $notation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notation_index');
        }

        return $this->render('notation/edit.html.twig', [
            'notation' => $notation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="notation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Notation $notation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($notation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notation_index');
    }
}
