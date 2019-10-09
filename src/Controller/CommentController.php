<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Country;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/{countryId}", name="comment_index", methods={"GET"})
     */
    public function index(CommentRepository $commentRepository,$countryId): Response
    {
        $country = $this->getDoctrine()->getRepository(Country::class)->find($countryId);
        $comment = $country->getComments();
        return $this->json([
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/new/{idCountry}/{idUser}", name="comment_new", methods={"GET","POST"})
     */
    public function new(?UserInterface $user, Request $request, $idCountry, $idUser)
    {
        $value = json_decode($request->getContent());
        
        $country = $this->getDoctrine()->getRepository(Country::class)->find($idCountry);
        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);
        $comment = new Comment();
        // on crée la date
        $comment->setPublishDate(new \DateTime('now'));
        $comment->setUser($user);
        $comment->setCountry($country);
        $comment->setText($value->text);
        $this->getDoctrine()->getManager()->persist($comment);
        $this->getDoctrine()->getManager()->flush($comment);

        $data = [
            'status' => 201,
            'message' => 'ok',
        ];
        return new JsonResponse($data, 201);  

    }

    /**
     * @Route("/{id}", name="comment_show", methods={"GET"})
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comment_index');
    }
}
