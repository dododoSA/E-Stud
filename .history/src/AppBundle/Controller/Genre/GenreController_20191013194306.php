<?php

namespace AppBundle\Controller\Genre;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends Controller {
    /**
     * 
     * @Route("/course", name="course_list")
     * 
     */
    public function listAction() {
        return $this->render("Course/list.html.twig");
    }
}