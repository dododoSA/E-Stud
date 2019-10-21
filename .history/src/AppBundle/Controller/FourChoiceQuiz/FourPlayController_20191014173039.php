<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RadioType;

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
        $session = $request->getSession();

        $form = $this->createFormBuilder()
            ->add('1', RadioType::class)
            ->add('2', RadioType::class)
            ->add('3', RadioType::class)
            ->add('4', RadioType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $request->getSession();
        }

        $this->render("FourChoiceQuiz/FourPlay/quiz.html.twig");
    }
}