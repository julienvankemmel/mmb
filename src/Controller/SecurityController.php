<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/apiuser")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface
         $passwordEncoder, EntityManagerInterface $entityManager,
        SerializerInterface $serializer, ValidatorInterface $validator) {
        $values = json_decode($request->getContent());
        if (isset($values->username, $values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user,
                $values->password));
            $user->setRoles($user->getRoles());

            // set le isActif à false en db
            $user->setIsActif(false);
            $errors = $validator->validate($user);
            if (count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json',
                ]);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $data = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé',
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les clés usermail et
password',
        ];
        return new JsonResponse($data, 500);
    }


   /**
    * @Route("/userdata", name="userdata", methods={"GET"})
    * retourne les datas de l'utilisateur connecté
    */
    public function getUserData(Request $request, UserInterface $user)
    {
        $user = $this->getUser();
        return $this->json([
            'user' => $user,
            
        ]);
    }
}