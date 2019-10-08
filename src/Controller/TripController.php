<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Form\TripType;
use App\Entity\Country;
use App\Repository\TripRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/trip")
 */
class TripController extends AbstractController
{
    /**
     * @Route("/", name="trip_index", methods={"GET"})
     */
    public function index(TripRepository $tripRepository): Response
    {
        return $this->render('trip/index.html.twig', [
            'trips' => $tripRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{idCountry}/{idUser}", name="trip_new", methods={"GET","POST"})
     */
    public function new(?UserInterface $user, Request $request, $idCountry, $idUser)
    {

        $values = json_decode($request->getContent());

        $country = $this->getDoctrine()->getRepository(Country::class)->find($idCountry);
        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);

        $trip = new Trip();

        $trip->setName($values->name);
        $trip->setStartDate(new \DateTime($values->startDate));
        $trip->setEndDate(new \DateTime($values->endDate));
        $trip->setContent($values->content);
        $trip->setUser($user);
        $trip->setCountry($country);

        $this->getDoctrine()->getManager()->persist($trip);
        $this->getDoctrine()->getManager()->flush($trip);

        $data = [
            'status' => 201,
            'message' => 'Votre voyage est enregistré avec succés.'
        ];
        return new JsonResponse($data, 201);

    }

    /**
     * @Route("/{id}", name="trip_show", methods={"GET"})
     */
    public function show(Trip $trip): Response
    {
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="trip_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Trip $trip): Response
    {
        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trip_index');
        }

        return $this->render('trip/edit.html.twig', [
            'trip' => $trip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trip_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Trip $trip): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trip->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trip_index');
    }
}
