<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\component\HttpFoundation\Request;

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
    public function quizAction(Request $request, $quiz_num) {
        $session

        $this->render("FourChoiceQuiz/FourPlay/quiz.html.twig");
    }
}