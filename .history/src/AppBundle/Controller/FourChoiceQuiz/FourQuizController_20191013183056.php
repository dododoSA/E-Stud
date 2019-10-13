<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\FourChoiceQuiz\FourChoiceQuizType;
use AppBundle\Entity\FourChoiceQuiz;

class FourQuizController extends Controller {
    /**
     * @Route("/four", name="four_index")
     */
    public function indexAction() {
        return $this->render('FourChoiceQuiz/index.html.twig');
    }

    /**
     * @Route("/four/{course_id}/new", name="four_quiz_new")
     */
    public function newAction(Request $request, $course_id) {
        $fcq = new FourChoiceQuiz();
        $form = $this->createForm(FourChoiceQuizType::class, $fcq);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fcq = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($fcq);
            $em->flush();

            return $this->redirectToRoute('four_course_edit');
        }

        return $this->render('FourChoiceQuiz/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}