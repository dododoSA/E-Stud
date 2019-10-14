<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FourChoiceQuiz\FourCourse;
use AppBundle\Entity\FourChoiceQuiz\FourQuiz;

class FourCourseController extends Controller {
    /**
     * @Route("/genre/four", name="four_course_list")
     */
    public function listAction() {  //問の一覧
        $courses = $this->getDoctrine()->getRepository(FourCourse::class)->findAll();


        return $this->render("FourChoiceQuiz/FourCourse/list.html.twig", [
            'courses' => $courses
        ]);
    }

    /**
     * @Route("/genre/four/{id}/show", name="four_course_show")
     */
    public function showAction($id) {  //問の質問一覧(RoutingをQuiz側のlistにするかどうか迷い中)
        $quizzes = $this->getDoctrine()->getRepository(FourQuiz::class)->findByFourCourseId($id);

        usort($quizzes, function ($a, $b) {
            return ($a->getQuizNum() < $b->getQuizNum()) ? -1 : 1;
        });

        return $this->render("FourChoiceQuiz/FourCourse/show.html.twig", [
            'quizzes' => $quizzes,
            'four_course_id' => $id
        ]);
    }

    /**
     * @Route("/genre/four/new", name="four_course_new")
     */
    public function newAction(Request $request) {  //問の新規作成
        $course = new FourCourse();

        $form = $this->createFormBuilder($course)
            ->add('name', TextType::class, ['attr' => ['placeholder' => 'New Problem Name']])
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $course = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('four_course_list');
        }

        return $this->render("FourChoiceQuiz/FourCourse/new.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/genre/four/{id}/edit", name="four_course_edit")
     */
    public function editAction(Request $request, $id) {  //問の名前変更
        $course = $this->getDoctrine()->getRepository(FourCourse::class)->find($id);
        if (!$course) {
            throw $this->createNotFoundException(
                'No course found for id'.$id
            );
        }

        $form = $this->createFormBuilder($course)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            return $this->redirectToRoute('four_course_list');
        }

        return $this->render("FourChoiceQuiz/FourCourse/edit.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/genre/four/{id}/delete", name="four_course_delete")
     */
    public function deleteAction($id) {  //問の削除
        $course = $this->getDoctrine()->getRepository(FourCourse::class)->find($id);

        if(!$course) {
            throw $this->createNotFoundException();
        }

        //その問の設問も削除
        $quizzes = $this->getDoctrine()->getRepository(FourQuiz::class)->findByFourCourseId($id);

        $em = $this->getDoctrine()->getManager();

        $em->remove($course);
        foreach ($quizzes as $quiz) {
            $em->remove($quiz);
        }
        $em->flush();

        return $this->redirectToRoute('four_course_list');
    }
}