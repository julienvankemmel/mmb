<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use DateTimeInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->json($userRepository->findAll());
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    function new (Request $request): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"PUT"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager,
        SerializerInterface $serializer, ValidatorInterface $validator): Response {
        $values = json_decode($request->getContent());
        if ($values) {

            $user->setFirstName($values->firstName);
            $user->setLastName($values->lastName);
            $user->setEmail($values->email);
            $user->setDateOfBirth(new \DateTime($values->dateOfBirth));
            $user->setAvatar($values->avatar);
             
            
            $errors = $validator->validate($user);
            if (count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json',
                ]);
            }

            $this->getDoctrine()->getManager()->flush($user);

            $data = [
                'status' => 201,
                'message' => 'Votre profil a été mis à jour',
            ];
            return new JsonResponse($data, 201);

        }

        $data = [
            'status' => 500,
            'message' => 'Erreur lors de l\'enregistrement',
        ];
        return new JsonResponse($data, 500);

    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

}
