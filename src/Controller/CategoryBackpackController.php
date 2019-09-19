<?php

namespace App\Controller;

use App\Entity\CategoryBackpack;
use App\Form\CategoryBackpackType;
use App\Repository\CategoryBackpackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category/backpack")
 */
class CategoryBackpackController extends AbstractController
{
    /**
     * @Route("/", name="category_backpack_index", methods={"GET"})
     */
    public function index(CategoryBackpackRepository $categoryBackpackRepository): Response
    {
        return $this->render('category_backpack/index.html.twig', [
            'category_backpacks' => $categoryBackpackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="category_backpack_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoryBackpack = new CategoryBackpack();
        $form = $this->createForm(CategoryBackpackType::class, $categoryBackpack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryBackpack);
            $entityManager->flush();

            return $this->redirectToRoute('category_backpack_index');
        }

        return $this->render('category_backpack/new.html.twig', [
            'category_backpack' => $categoryBackpack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_backpack_show", methods={"GET"})
     */
    public function show(CategoryBackpack $categoryBackpack): Response
    {
        return $this->render('category_backpack/show.html.twig', [
            'category_backpack' => $categoryBackpack,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_backpack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryBackpack $categoryBackpack): Response
    {
        $form = $this->createForm(CategoryBackpackType::class, $categoryBackpack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_backpack_index');
        }

        return $this->render('category_backpack/edit.html.twig', [
            'category_backpack' => $categoryBackpack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_backpack_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoryBackpack $categoryBackpack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryBackpack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoryBackpack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_backpack_index');
    }
}
