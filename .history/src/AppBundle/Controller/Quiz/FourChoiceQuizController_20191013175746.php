<?php

namespace AppBundle\Controller\Quiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\FourChoiceQuiz\FourChoiceQuizType
use AppBundle\Entity\FourChoiceQuiz;

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
        $fcq = new FourChoiceQuiz();
        $form = $this->createForm(FourChoiceQuizType::class, $fcq);
        return $this->render('FourChoiceQuiz/new.html.twig');
    }
}