<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use App\Form\ProgramSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     *
     * @Route("/", name="wild_index")
     * @return Response A response instance
     */
    public function index(Request $request): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        // formulaire de recherche

        $formS = $this->createForm(
            ProgramSearchType::class);
        $formS->handleRequest($request);

        if ($formS->isSubmitted()) {

            $data = implode($formS->getData());
            echo $data;

            $programs = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findBy(['title' => mb_strtolower($data)]);
        }

        return $this->render('wild/index.html.twig', ['programs' => $programs,'programs' => $programs,

            'formS' => $formS->createView()]);

    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function showByProgram (?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        $seasons = $this->getDoctrine()
            ->getRepository( Season::Class)
            ->findBy( ['program'=>$program],
                ['id'=> "ASC"]);
        $actors = $program->getActors();

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
            'season' => $seasons,
            'actors' => $actors,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title and can see all episode from season
     *
     * @param int $id The id season
     * @Route("/show_episode/{id}",  name="show_episode")
     * @return Response
     */
    public function showBySeason (?int $id): Response
    {

            $season = $this->getDoctrine()
                ->getRepository(Season::Class)
                ->findOneBy(['id' => $id]);

            $program = $season->getProgram();

            $episode = $season->getEpisodes();


        return $this->render('wild/showEpisode.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }
    /**
     * Getting a program choose by category
     *
     * @param string $categoryName The category
     * @Route("/category/{categoryName}", defaults={"slug" = null}, name="category")
     * @return Response
     */
    public function showByCategory(?string $categoryName): response
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }

        if ($categoryName) {

            $category = $this->getDoctrine()
                ->getRepository(Category::class)
                ->findOneBy(['name' => ucwords($categoryName)]);

        }
        if (!$category) {
            throw $this
                ->createNotFoundException('No category found with this '.$categoryName.'.');
        }
            $programByCategory = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findBy(['category' => $category],
                    ['id' => 'desc'],
                    3);


        if (!$programByCategory) {
            throw $this->createNotFoundException(
                'No program in this '.$categoryName.', found in program\'s table.'
            );
        }

        return $this->render('wild/category.html.twig', [
            'programs' => $programByCategory,
            'categoryName' => $category
        ]);
    }

    /**
     * Getting a program with a formatted slug for title and can see all episode from season
     *
     * @param int $id
     * @Route("/episode/{id}",  name="episode")
     * @return Response
     */
    public function showEpisode (Episode $episode): Response
    {
        $season = $episode->getSeason();

        $program = $season->getProgram();




        return $this->render('wild/Episode.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }

    /**
     * Getting a actor with program where he is playing
     *
     * @param string $actor
     * @Route("/actor/{name}",  name="actor")
     * @ParamConverter("actor", options={"mapping": {"name"="name"}})
     * @return Response
     */
    public function showByActor (Actor $actor): Response
    {
            $programs = $actor->getprograms();



        return $this->render('wild/actor.html.twig', [
            'actor' => $actor,
            'programs' => $programs

        ]);
    }

}
