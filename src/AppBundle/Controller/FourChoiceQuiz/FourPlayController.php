<?php

namespace AppBundle\Controller\FourChoiceQuiz;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\FourChoiceQuiz\FourQuiz;
use AppBundle\Entity\FourChoiceQuiz\FourCourse;
use AppBundle\Entity\FourChoiceQuiz\FourResult;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */

class FourPlayController extends Controller {
    /**
     * @Route("/genre/four/{four_course_id}/play", name="four_play_index")
     */
    public function indexAction(Request $request, $four_course_id) {
        $course = $this->getDoctrine()->getRepository(FourCourse::class)->find($four_course_id);
        $session = $request->getSession();

        $session->set('selected_four_course_id', $four_course_id);

        return $this->render("FourChoiceQuiz/FourPlay/index.html.twig", [
            "course" => $course
        ]);
    }

    /**
     * @Route("/genre/four/{four_course_id}/play/{quiz_num}", name="four_play_quiz", requirements={"quiz_num": "\d+"})
     */
    public function quizAction(Request $request, $four_course_id, $quiz_num) {
        $session = $request->getSession();

        //クイズを取得
        $quiz = $this->getQuiz($four_course_id, $quiz_num);
        if (!$quiz) {
            throw $this->createNotFoundException('');
        }

        //途中から開始するのを防ぐため
        if ($session->get('selected_four_course_id') != $four_course_id) {
            $this->addFlash(
                'error',
                '不正なリクエストです'
            );
            return $this->redirectToRoute('four_play_index', [
                'four_course_id' => $four_course_id
            ]);
        }

        //URLのパラメータ操作によって問題を飛ばすのを防ぐため
        if ($quiz_num != 1) {
            $four_results = $session->get('four_results');
            for ($i = 1; $i < $quiz_num; $i++) { 
                if(!isset($four_results[$i])) {
                    $this->addFlash(
                        'error',
                        '不正なリクエストです'
                    );
                    return $this->redirectToRoute('four_play_index', [
                        'four_course_id' => $four_course_id
                    ]);
                }
            }
        }

        //選択肢を生成
        $choices = $this->getChoices($quiz);

        //フォームを作成
        $form = $this->createFormBuilder()
            ->add('answer', ChoiceType::class, [
                'choices' => [
                    $choices[1] => $choices[1],
                    $choices[2] => $choices[2],
                    $choices[3] => $choices[3],
                    $choices[4] => $choices[4],
                ],
                'expanded' => true
            ])
            ->add('next', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        //選択を受け付けたら
        if ($form->isSubmitted() && $form->isValid()) {

            $results = $session->get('four_results');
            $user_choices = $session->get('user_choices');
            //正誤判定
            //セッションに結果を書き込む
            $user_answer = $form['answer']->getData();

            if ($user_answer == $quiz->getCorrectAns()) {
                $results[$quiz_num] = 'correct';
            }
            else {
                $results[$quiz_num] = 'wrong';
            }
            $user_choices[$quiz_num] = $user_answer;
            $session->set('four_results', $results);
            $session->set('user_choices', $user_choices);


            //クイズが最後かどうかで場合分け
            if ($quiz->getIsLast()) {
                return $this->redirectToRoute('four_play_result', [
                    'four_course_id' => $four_course_id
                    ]);
            } else {
                return $this->redirectToRoute('four_play_quiz', [
                    'four_course_id' => $four_course_id,
                    'quiz_num' => $quiz_num + 1
                    ]);
            }
        }

        $choice_num = [0, 1, 2, 3];

        shuffle($choice_num);

        return $this->render("FourChoiceQuiz/FourPlay/quiz.html.twig", [
            "form" => $form->createView(),
            "choice_num" => $choice_num,
            "quiz" => $quiz
        ]);
    }

    /**
     * @Route("/genre/four/{four_course_id}/play/result", name="four_play_result")
     */
    function resultAction(Request $request, $four_course_id) {
        $session = $request->getSession();

        //途中から開始するのを防ぐため
        if ($session->get('selected_four_course_id') != $four_course_id) {
            $this->addFlash(
                'error',
                '不正なリクエストです'
            );
            return $this->redirectToRoute('four_play_index', [
                'four_course_id' => $four_course_id
            ]);
        }

        //コースのクイズをすべて取得
        $quizzes = $this->getDoctrine()->getRepository(FourQuiz::class)->findByFourCourseId($four_course_id);
        //QuizNumでソート 上のDBから持ってくるときにソートさせたほうがいいかも？
        usort($quizzes, function ($a, $b) {
            return ($a->getQuizNum() < $b->getQuizNum()) ? -1 : 1;
        });

        // //答え合わせ
        //結果を取得
        $results = $session->get('four_results');
        $user_choices = $session->get('user_choices');
        $em = $this->getDoctrine()->getManager();

        foreach($results as $quiz_num => $result) {
            $four_result = new FourResult;
            $four_result->setUserId($this->getUser()->getId());
            $four_result->setDate(new DateTime());
            $quiz  = $this->searchQuiz($quiz_num, $quizzes);
            if ($quiz !== null) {
                $four_result->setFourQuiz($quiz);//マジックナンバーをなくしたい
            } 
            $four_result->setResult($result);
            $em->persist($four_result);
        }


        $em->flush();

        //セッションを削除
        $session->remove('four_results');
        $session->remove('selected_four_course_id');
        $session->remove('user_choices');

        return $this->render("FourChoiceQuiz/FourPlay/result.html.twig", [
            'four_course_id' => $four_course_id,
            'quizzes' => $quizzes,
            'results' => $results,
            'user_choices' => $user_choices
        ]);
    }

    /**
     * quiz用
     */
    private function getQuiz($four_course_id, $quiz_num) {
        $repository = $this->getDoctrine()->getRepository(FourQuiz::class);
        $query = $repository->createQueryBuilder('q')
            ->where('q.fourCourseId = :four_course_id')
            ->andWhere('q.quizNum = :quiz_num')
            ->setParameters([
                'four_course_id' => $four_course_id, 
                'quiz_num' => $quiz_num
            ])
            ->getQuery();
        $quiz = $query->getSingleResult();

        return $quiz;
    }

    private function getChoices($quiz) {
        $choices = [
            1 => $quiz->getCorrectAns(),
            2 => $quiz->getWrongAns1(),
            3 => $quiz->getWrongAns2(),
            4 => $quiz->getWrongAns3(),
        ];
        
        return $choices;
    }

    private function searchQuiz($quiz_num, $quizzes) {
        //線形探索
        foreach ($quizzes as $quiz) {
            if ($quiz_num == $quiz->getQuizNum()) {
                return $quiz;
            }
        }
        return null;
    }
}