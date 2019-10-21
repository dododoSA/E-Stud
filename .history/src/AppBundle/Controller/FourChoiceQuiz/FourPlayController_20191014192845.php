<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            1 => $quiz->getCorrectAns(),
            2 => $quiz->getWrongAns1(),
            3 => $quiz->getWrongAns2(),
            4 => $quiz->getWrongAns3(),
        );

        shuffle($choices);

        $session = $request->getSession();

        foreach ($choices as $key => $value) {
            if ($value == $quiz->getCorrectAns()) {
                $correct_choices = $session->get['correct_choices'];
                $correct_choices[$quiz_num] = $key;
                $session->set('correct_choices', $correct_choices);
            }
        }

        $form = $this->createFormBuilder()
            ->add('answer', ChoiceType::class, [
                'choices' => [
                    '1.'.$choices[0] => 1,
                    '2.'.$choices[1] => 2,
                    '3.'.$choices[2] => 3,
                    '4.'.$choices[3] => 4,
                ],
                'expanded' => true
            ])
            ->add('next', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $correct_choice = $session->get('correct_choices')[$quiz_num];
            $user_answer = $form->getData()['answer'];
            if ($correct_choice == $user_answer) {

            }

            $this->redirectToRoute('');
        }

        $this->render("FourChoiceQuiz/FourPlay/quiz.html.twig");
    }

    /**
     * @Route("/genre/four/play/result")
     */
}