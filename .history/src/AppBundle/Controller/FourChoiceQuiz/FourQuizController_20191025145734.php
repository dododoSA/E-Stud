<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\FourChoiceQuiz\FourQuizType;
use AppBundle\Entity\FourChoiceQuiz\FourQuiz;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FourQuizController extends Controller {
    /**
     * @Route("/genre/four", name="four_index")
     */
    public function indexAction() {
        return $this->render('FourChoiceQuiz/index.html.twig');
    }

    /**
     * @Route("/genre/four/{four_course_id}/quiz/new", name="four_quiz_new")
     */
    public function newAction(Request $request, $four_course_id) {  //問題の新規作成
        $quiz = new FourQuiz();
        $form = $this->createFormBuilder($quiz)
            ->add('question', TextType::class)
            ->add('correctAns', TextType::class)
            ->add('wrongAns1', TextType::class)
            ->add('wrongAns2', TextType::class)
            ->add('wrongAns3', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quiz = $form->getData();
            $quiz->setFourCourseId($four_course_id);
            
            //途中に挿入するときは他の問題の番号をずらす
            $quizzes = $this->getDoctrine()->getRepository(FourQuiz::class)->findByFourCourseId($four_course_id); 
            $quiz->setQuizNum($this->getLastQuizNum($quizzes) + 1);
            $quizzes[] = $quiz;
            //最後の問題を探す
            $this->setLastQuiz($quizzes);

            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();

            return $this->redirectToRoute('four_course_show', ['id' => $four_course_id]);
        }

        return $this->render("FourChoiceQuiz/FourQuiz/new.html.twig", [
            'form' => $form->createView(),
            'four_course_id' => $four_course_id
        ]);
    }

    /**
     * @Route("/genre/four/{four_course_id}/quiz/{id}/edit", name="four_quiz_edit")
     */
    public function editAction(Request $request, $four_course_id, $id) {  //問題の編集
        $quiz = $this->getDoctrine()->getRepository(FourQuiz::class)->find($id);

        if (!$quiz || $quiz->getFourCourseId() != $four_course_id) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder($quiz)
            ->add('question', TextType::class)
            ->add('quizNum', NumberType::class)
            ->add('correctAns', TextType::class)
            ->add('wrongAns1', TextType::class)
            ->add('wrongAns2', TextType::class)
            ->add('wrongAns3', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $before_quiz_num = $quiz->getQuizNum();
            $quiz = $form->getData();

            //途中に挿入するときは一度削除して空いた分をつめて、その後挿入して以降をずらす
            $quizzes = $this->getDoctrine()->getRepository(FourQuiz::class)->findByFourCourseId($four_course_id);
            dump($quizzes);
            foreach ($quizzes as $another_quiz) {
                if ($another_quiz->getQuizNum() >= $before_quiz_num) {
                    $another_quiz->setQuizNum($another_quiz->getQuizNum() - 1);
                }
            }
            dump($before_quiz_num);
            dump($quizzes);
            foreach ($quizzes as $another_quiz) {
                if ($another_quiz->getQuizNum() >= $quiz->getQuizNum()) {
                    $another_quiz->setQuizNum($another_quiz->getQuizNum() + 1);
                }
            }
            dump($quizzes);

            //最後の問題を探す
            $this->setLastQuiz($quizzes);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('four_course_show', ['id' => $four_course_id]);
        }

        return $this->render('FourChoiceQuiz/FourQuiz/edit.html.twig', [
            'form' => $form->createView(),
            'four_course_id' => $four_course_id,
        ]);
    }

    /**
     * @Route("/genre/four/{four_course_id}/)quiz/{id}/delete", name="four_quiz_delete")
     */
    public function deleteAction($four_course_id, $id) {
        $quiz = $this->getDoctrine()->getRepository(FourQuiz::class)->find($id);

        if (!$quiz || $quiz->getFourCourseId() != $four_course_id) {
            throw $this->createNotFoundException();
        }

        //途中を削除するときは他の問題の番号をずらす
        $quizzes = $this->getDoctrine()->getRepository(FourQuiz::class)->findByFourCourseId($four_course_id);
        foreach ($quizzes as $another_quiz) {
            if ($another_quiz->getQuizNum() >= $quiz->getQuizNum()) {
                $another_quiz->setQuizNum($another_quiz->getQuizNum() - 1);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($quiz);
        $em->flush();

        return $this->redirectToRoute('four_course_show', [
            'id' => $four_course_id
        ]);
    }

    private function getLastQuizNum($quizzes) {
        $last_quiz_num = 0;

        foreach ($quizzes as $quiz) {
            if ($quiz->getQuizNum() > $last_quiz_num) {
                $last_quiz_num = $quiz->getQuizNum();
            }
        }

        return $last_quiz_num;
    }

    private function setLastQuiz(&$quizzes) {
        foreach ($quizzes as $another_quiz) {
            $another_quiz->setIsLast(false);
        }
        $last_quiz = reset($quizzes);
        $last_quiz->setIsLast(true);
        foreach ($quizzes as $another_quiz) {
            if ($another_quiz->getQuizNum() >= $last_quiz->getQuizNum()) {
                $last_quiz->setIsLast(false);
                $last_quiz = $another_quiz;
                $another_quiz->setIsLast(true);
                
            }
        }
    }
}