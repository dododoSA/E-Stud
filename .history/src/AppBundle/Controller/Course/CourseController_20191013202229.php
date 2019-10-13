<?php

namespace AppBundle\Controller\Course;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Course;

class CourseController extends Controller {
    /**
     * @Route("/genre/{genre_name}", name="course_list")
     */
    public function listAction($genre_name) {
        if (!isGenreNameValid($genre_name)) {
            throw $this->createNotFoundException('There is no such genre.');
        }

        $courses = $this->getRepository(FourCourse::class)->findByGenreName($genre_name);


        return $this->render("FourChoiceQuiz/FourCourse/list.html.twig", [
            'courses' => $courses
        ]);
    }

    /**
     * @Route("/genre/{genre_name}/show, name="course_show")
     */


    private function isGenreNameValid($genre_name) {
        switch ($genre_name) {
            case 'four':
                return true;
                break;

            default:
                return false;
                break;
        }
    }
}