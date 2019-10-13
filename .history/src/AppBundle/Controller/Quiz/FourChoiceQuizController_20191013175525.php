<?php

namespace AppBundle\Controller\Quiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FourChoiceQuizController extends Controller {
    /**
     * @Route("/four", name="four_index")
     */
    public function indexAction() {
        return $this->render('FourChoiceQuiz/index.html.twig');
    }

    /**
     * @Route("/four/new", name="four_new")
     */
    public function newAction() {
        return $this->render('FourChoiceQuiz/new.html.twig')
    }
}