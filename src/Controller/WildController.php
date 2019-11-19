<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }
    // requirements={"slug"="[^ABCDEFGHIJKLMNOPQRSTUVWXYZ]|[^_]"},

    /**
     * @Route("/wild/show/{slug}",defaults = {"slug":""},
     *     methods={"GET"}, name="wild_show")
     */
    public function show($slug): Response
    {

        if (preg_match('/[A-Z]|[_]/', $slug)) {
            $error = "Erreur 404";
            return $this->render('wild/show.html.twig', ['slug' => $error]);
        } else {
            $truc = ["^", "$", "\\", "|", "{", "}", "[", "]", "(", ")", "?", "#", "!", "+", "*", "_", "-"];
            $slugy = ucwords(str_replace($truc, " ", $slug));
            return $this->render('wild/show.html.twig', ['slug' => $slugy]);

        }
    }
}
