<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Backpack;
use App\Entity\BackpackItem;
use App\Form\BackpackItemType;
use App\Repository\BackpackItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/backpackitem")
 */
class BackpackItemController extends AbstractController
{
    /**
     *@Route("/", name="backpack_item_index", methods={"GET"})
     */
    public function index(BackpackItemRepository $backpackItemRepository): Response
    {
        return $this->json([
            'backpack_items' => $backpackItemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{idUser}/{idBackpack}", name="backpack_item_new", methods={"GET","POST"})
     */
    public function new(?UserInterface $user,Request $request,$idUser,$idBackpack): Response
    {
        $value = $request->getContent();

        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);
        $backpack = $this->getDoctrine()->getRepository(Backpack::class)->find($idBackpack);

        $backpackItem = new BackpackItem();
        
        $backpackItem->setAddDate(new \DateTime('now'));
        $backpackItem->setModifyDate(new \DateTime('now'));
        $backpackItem->setName($value->name);
        $backpackItem->setUser($user);
        $backpackItem->setCategoryItem($value->categorie);
        $backpackItem->setBackpacks($backpack);

      
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($backpackItem);
            $entityManager->flush($backpackItem);

            $data = [
                'status' => 201,
                'message' => 'ok',
            ];
            return new JsonResponse($data, 201);  
    }

    /**
     * @Route("/{id}", name="backpack_item_show", methods={"GET"})
     */
    public function show(BackpackItem $backpackItem): Response
    {
        return $this->json([
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
