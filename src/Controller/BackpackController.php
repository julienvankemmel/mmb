<?php

namespace App\Controller;

use App\Entity\Backpack;
use App\Form\BackpackType;
use App\Repository\BackpackRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/backpack")
 *
 */
class BackpackController extends AbstractController
{
    /**
     * @Route("/", name="backpack_index", methods={"GET"})
     */
    public function index(BackpackRepository $backpackRepository): Response
    {   
       
        return $this->json($backpackRepository->findAll());
    }

    /**
     * @Route("/new", name="backpack_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $backpack = new Backpack();
        $form = $this->createForm(BackpackType::class, $backpack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($backpack);
            $entityManager->flush();

            return $this->redirectToRoute('backpack_index');
        }

        return $this->render('backpack/new.html.twig', [
            'backpack' => $backpack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backpack_show", methods={"GET"})
     */
    public function show(Backpack $backpack): Response
    {
        return $this->render('backpack/show.html.twig', [
            'backpack' => $backpack,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backpack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Backpack $backpack): Response
    {
        $form = $this->createForm(BackpackType::class, $backpack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backpack_index');
        }

        return $this->render('backpack/edit.html.twig', [
            'backpack' => $backpack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backpack_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Backpack $backpack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$backpack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($backpack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backpack_index');
    }

   

    
}
