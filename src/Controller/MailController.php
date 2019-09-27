<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function register(Request $request, SerializerInterface $serializer, ValidatorInterface $validator,  \Swift_Mailer $mailer)
    {
        $values = json_decode($request->getContent());
        if (isset($values->email, $values->msg, $values->subject)) {

            $emailConstraint = new Assert\Email();
            // all constraint "options" can be set this way
            $emailConstraint->message = 'Invalid email address';

            // use the validator to validate the value
            $errors = $validator->validate(
                $values->email,
                $emailConstraint
            );

            if (0 === count($errors)) {
                $message = (new \Swift_Message($values->subject))
                ->setFrom($values->email)
                ->setTo('makemybackpack@gmail.com')
                ->setBody('From : '.$values->email.'<br> Message : '.$values->msg,'text/html');

                $mailer->send($message);
        
                $data = [
                    'status' => 201,
                    'message' => 'Votre message a bien été envoyé, merci !',
                ];
                return new JsonResponse($data, 201);  
            }else{
                $data = [
                    'status' => 500,
                    'violations' => [
                        [
                            'title' => $errors[0]->getMessage(),
                        ],
                ]
                ];
                return new JsonResponse($data, 500);
            }
        }
    }
 
}
