<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FourCourseController extends Controller {
    /**
     * @Route("/four", name="four_list")
     */
    public function listAction() {
        $em = $this->getDoctrine()->getManager();
        $course

        return $this->render("FourChoiceQuiz/FourCourse/list.html.twig");
    }
}