<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class FourPlayController extends Controller {
    /**
     * @Route("/genre/four/play", name="four_play_index")
     */
    public function indexAction() {
        
        $this->render("FourChoiceQuiz/FourPlay/index.html.twig");
    }

    /**
     * @Route("/genre/four/play/{quiz_num}", name="four_play_quiz")
     */
    public function quizAction($quiz_num) {
        
        $this->render("FourChoiceQuiz/FourPlay/quiz.html.twig");
    }
}