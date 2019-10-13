<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\FourChoiceQuiz\FourChoiceQuizType;
use AppBundle\Entity\FourChoiceQuiz;

class QuizController extends Controller {
    /**
     * @Route("/four", name="four_index")
     */
    public function indexAction() {
        return $this->render('FourChoiceQuiz/index.html.twig');
    }

    /**
     * @Route("/four/{course_num}/new", name="four_quiz_new")
     */
    public function newAction(Request $request, $course_num) {
        $fcq = new FourChoiceQuiz();
        $form = $this->createForm(FourChoiceQuizType::class, $fcq);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fcq = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($fcq);
            $em->flush();
        }

        return $this->render('FourChoiceQuiz/new.html.twig');
    }

}