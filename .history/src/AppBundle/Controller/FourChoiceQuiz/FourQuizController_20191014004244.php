<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\FourChoiceQuiz\FourQuizType;
use AppBundle\Entity\FourChoiceQuiz\FourQuiz;

class FourQuizController extends Controller {
    /**
     * @Route("/genre/four", name="four_index")
     */
    public function indexAction() {
        return $this->render('FourChoiceQuiz/index.html.twig');
    }

    /**
     * @Route("/genre/four/{course_id}/quiz/new", name="four_quiz_new")
     */
    public function newAction(Request $request, $course_id) {  //質問の新規作成
        $fcq = new FourQuiz();
        // $form = $this->createForm(FourQuizType::class, $fcq);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $fcq = $form->getData();
        //     $fcq->setFourCourseId($course_id);
            
        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($fcq);
        //     $em->flush();

        //     return $this->redirectToRoute('four_course_show');
        // }

        return $this->render("FourChoiceQuiz/FourQuiz/new.html.twig", [
//            'form' => $form->createView(),
        ]);
    }

}