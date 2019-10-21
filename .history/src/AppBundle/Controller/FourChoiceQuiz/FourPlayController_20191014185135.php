<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\FourChoiceQuiz\FourQuiz;

class FourPlayController extends Controller {
    /**
     * @Route("/genre/four/play", name="four_play_index")
     */
    public function indexAction() {
        
        $this->render("FourChoiceQuiz/FourPlay/index.html.twig");
    }

    /**
     * @Route("/genre/four/{four_course_id}/play/{quiz_num}", name="four_play_quiz")
     */
    public function quizAction(Request $request, $four_course_id, $quiz_num) {
        $repository = $this->getDoctrine()->getRepository(FourQuiz::class);

        $query = $repository->createQueryBuilder('q')
            ->where('q.fourCourseId = :four_course_id')
            ->andWhere('q.quizNum = :quiz_num')
            ->setParameters([
                'four_course_id' => $four_course_id, 
                'quiz_num' => $quiz_num
            ])
            ->getQuery();

        $quiz = $query->getResult();

        if (!$quiz) {
            throw $this->createNotFoundException('');
        }

        $choices = array(
            $quiz->getCorrectAns(),
            $quiz->getWrongAns1(),
            $quiz->getWrongAns2(),
            $quiz->getWrongAns3(),
        );

        $form = $this->createFormBuilder()
            ->add('answer', ChoiceType::class, [
                'choices' => [
                    '1.'.$choices[0] => 1,
                    '2.'.$choices[1] => 2,
                    '3.'.$choices[2] => 3,
                    '4.'.$choices[3] => 4
                ],
                'expanded' => true
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $request->getSession();
        }

        $this->render("FourChoiceQuiz/FourPlay/quiz.html.twig");
    }

    /**
     * @Route("/genre/four/play/result")
     */
}