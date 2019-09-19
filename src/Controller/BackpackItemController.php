<?php

namespace App\Controller;

use App\Entity\BackpackItem;
use App\Form\BackpackItemType;
use App\Repository\BackpackItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backpack/item")
 */
class BackpackItemController extends AbstractController
{
    /**
     * @Route("/", name="backpack_item_index", methods={"GET"})
     */
    public function index(BackpackItemRepository $backpackItemRepository): Response
    {
        return $this->render('backpack_item/index.html.twig', [
            'backpack_items' => $backpackItemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="backpack_item_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $backpackItem = new BackpackItem();
        $form = $this->createForm(BackpackItemType::class, $backpackItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($backpackItem);
            $entityManager->flush();

            return $this->redirectToRoute('backpack_item_index');
        }

        return $this->render('backpack_item/new.html.twig', [
            'backpack_item' => $backpackItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backpack_item_show", methods={"GET"})
     */
    public function show(BackpackItem $backpackItem): Response
    {
        return $this->render('backpack_item/show.html.twig', [
            'backpack_item' => $backpackItem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backpack_item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BackpackItem $backpackItem): Response
    {
        $form = $this->createForm(BackpackItemType::class, $backpackItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backpack_item_index');
        }

        return $this->render('backpack_item/edit.html.twig', [
            'backpack_item' => $backpackItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backpack_item_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BackpackItem $backpackItem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$backpackItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($backpackItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backpack_item_index');
    }
}
