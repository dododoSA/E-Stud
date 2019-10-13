<?php

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FourChoiceQuizController extends Controller {
    /**
     * @Route("/four", name="four_show")
     */
    public function showAction() {
        return $this->render('FourChoiceQuiz/show.html.twig');
    }
}