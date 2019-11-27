<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="add_category")
     */
    public function add(Request $request)
    {
        $categorys = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        // Créer une nouvelle catégorie

        $category = new Category();

        $form =$this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('add_category');

        }
        return $this->render('wild/addcategory.html.twig', ['categorys' => $categorys,
            'form' => $form->createView()]);
    }
}
