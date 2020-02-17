<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my-profile")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="profil", methods={"GET"})
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('profile/comment.html.twig', [
            'comments' => $commentRepository->findBy(['Author' => $this->getUser()])]);

    }


}
