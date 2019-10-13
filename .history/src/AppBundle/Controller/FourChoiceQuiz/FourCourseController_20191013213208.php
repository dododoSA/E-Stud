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
    public function listAction() {
        $courses = $this->getRepository(FourCourse::class)->findAll();


        return $this->render("FourChoiceQuiz/FourCourse/list.html.twig", [
            'courses' => $courses
        ]);
    }

    /**
     * @Route("/genre/four/{id}/show, name="four_course_show")
     */
    public function showAction($id) {
        $quizzes = $this->getRepository(FourCourse::class)->findByCourseId($id);

        return $this->render("FourChoiceQuiz/FourCourse/show.html.twig", [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * @Route("/genre/four/new", name="four_course_new")
     */
    public function newAction() {
        $course = new FourCourse();

        $form = $this->createFormBuilder($course)
            ->add('name')

        return $this->render("FourChoiceQuiz/FourCourse/new.html.twig", [

        ]);
    }
}