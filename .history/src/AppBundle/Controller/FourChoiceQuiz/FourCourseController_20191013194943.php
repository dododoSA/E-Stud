<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FourCourseController extends Controller {
    /**
     * @Route("/genre/{$name}", name="four_list")
     */
    public function listAction() {
        $courses = $this->getRepository();

        return $this->render("FourChoiceQuiz/FourCourse/list.html.twig");
    }
}