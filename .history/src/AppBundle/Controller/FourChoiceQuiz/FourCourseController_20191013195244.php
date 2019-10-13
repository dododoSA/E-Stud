<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FourChoiceQuiz\FourCourse;

class FourCourseController extends Controller {
    /**
     * @Route("/genre/{$genre_name}", name="four_list")
     */
    public function listAction($genre_name) {
        $courses = $this->getRepository(FourCourse::class)->findByGenreName($genre_name);

        return $this->render("FourChoiceQuiz/FourCourse/list.html.twig");
    }
}