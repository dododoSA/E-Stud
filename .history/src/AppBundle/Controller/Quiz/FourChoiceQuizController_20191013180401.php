<?php

namespace AppBundle\Controller\Quiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\FourChoiceQuiz\FourChoiceQuizType;
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
    public function newAction(Request $request) {
        $fcq = new FourChoiceQuiz();
        $form = $this->createForm(FourChoiceQuizType::class, $fcq);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fcq = $form->getData();
        }

        return $this->render('FourChoiceQuiz/new.html.twig');
    }

}