<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FourChoiceQuiz\FourCourse;

class FourCourseController extends Controller {
    /**
     * @Route("/genre/four", name="four_course_list")
     */
    public function listAction() {
        $courses = $this->getRepository(FourCourse::class)->findByGenreName($genre_name);


        return $this->render("FourChoiceQuiz/FourCourse/list.html.twig", [
            'courses' => $courses
        ]);
    }

    /**
     * @Route("/genre/{genre_name}/show, name="course_show")
     */

}