<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Entity\Country;
use App\Entity\Backpack;
use App\Form\BackpackType;
use App\Entity\BackpackItem;
use App\Repository\BackpackRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/new/{trip}/{id}", name="backpack_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id, $trip): Response
    {
      
        $value = json_decode($request->getContent());

        $trip = $this->getDoctrine()->getRepository(Trip::class)->find($trip);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $country = $this->getDoctrine()->getRepository(Country::class)->find($value->idCountry);

        $backpack = new Backpack();

        $backpack->setName($value->title);
        $backpack->setPublishedDate(new \DateTime('now'));
        $backpack->addUser($user);
        $backpack->addTrip($trip);
        $backpack->addCountry($country);
        $trip->addBackpack($backpack);

        $this->getDoctrine()->getManager()->persist($trip);
        $this->getDoctrine()->getManager()->persist($backpack);
        $this->getDoctrine()->getManager()->flush();

        $data = [
            'status' => 201,
            'message' => 'Votre backpack est enregistré avec succés.'
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/{id}", name="backpack_show", methods={"GET"})
     */
    public function show(Backpack $backpack): Response
    {
        return $this->json([
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
     * @Route("/delete/{id}", name="backpack_delete", methods={"DELETE"})
     */
    public function delete(Request $request, $id): Response
    {
        $backpack = $this->getDoctrine()->getRepository(Backpack::class)->find($id);
        $this->getDoctrine()->getManager()->remove($backpack);
        $this->getDoctrine()->getManager()->flush();
        
        $data = [
         'status' => 201,
         'message' => 'Votre voyage est enregistré avec succés.'
     ];
     return new JsonResponse($data, 201);
 
    }

   

    
}
