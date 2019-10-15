<?php

namespace App\Controller;

use App\Entity\CategoryItem;
use App\Form\CategoryItemType;
use App\Repository\CategoryItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categoryitem")
 */
class CategoryItemController extends AbstractController
{
    /**
     * @Route("/", name="category_item_index", methods={"GET"})
     */
    public function index(CategoryItemRepository $categoryItemRepository): Response
    {
        return $this->json($categoryItemRepository->findAll());
    }

    /**
     * @Route("/new", name="category_item_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoryItem = new CategoryItem();
        $form = $this->createForm(CategoryItemType::class, $categoryItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryItem);
            $entityManager->flush();

            return $this->redirectToRoute('category_item_index');
        }

        return $this->render('category_item/new.html.twig', [
            'category_item' => $categoryItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_item_show", methods={"GET"})
     */
    public function show(CategoryItem $categoryItem): Response
    {
        return $this->render('category_item/show.html.twig', [
            'category_item' => $categoryItem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryItem $categoryItem): Response
    {
        $form = $this->createForm(CategoryItemType::class, $categoryItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_item_index');
        }

        return $this->render('category_item/edit.html.twig', [
            'category_item' => $categoryItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_item_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoryItem $categoryItem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoryItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_item_index');
    }
}
