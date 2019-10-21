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
     * @Route("/genre/four/{four_course_id}/play/{quiz_num}", name="four_play_quiz")
     */
    public function quizAction(Request $request, $four_course_id, $quiz_num) {
        //クイズを取得　現在URLにうまい具合に数字を入れてしまえば途中からできてしまうのでその対策が必要
        $repository = $this->getDoctrine()->getRepository(FourQuiz::class);
        $session = $request->getSession();
        $query = $repository->createQueryBuilder('q')
            ->where('q.fourCourseId = :four_course_id')
            ->andWhere('q.quizNum = :quiz_num')
            ->setParameters([
                'four_course_id' => $four_course_id, 
                'quiz_num' => $quiz_num
            ])
            ->getQuery();
        $quiz = $query->getResult();

        dump($quiz);

        if (!$quiz) {
            throw $this->createNotFoundException('');
        }

        if ($session->get('selected_four_course_id') != $four_course_id) {
            $this->addFlash(
                'error',
                '不正なリクエストです'
            );
            return $this->redirectToRoute('four_play_index', [
                'four_course_id' => $four_course_id
            ]);
        }

        $a = 

        //選択肢を生成
        $choices = [
            1 => $quiz['correctAns'],    //オブジェクトに代入されてない
            2 => $quiz["wrongAns1"],
            3 => $quiz["wrongAns2"],
            4 => $quiz-["wrongAns3"],
        ];

        shuffle($choices);

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

        //セッションに正解と問題idを書き込む

        foreach ($choices as $key => $value) {
            if ($value == $quiz->getCorrectAns()) {
                $correct_choices = $session->get['correct_choices'];
                $correct_choices[$quiz_num] = $key;
                $session->set('correct_choices', $correct_choices);
            }
        }


        $form->handleRequest($request);

        //選択を受け付けたら
        if ($form->isSubmitted() && $form->isValid()) {
            $form_data = $form->getData();
            $user_answer = $form_data['answer'];
            $user_choices = $session->get('user_choices');
            $user_choices[$quiz_num] = $user_answer;
            $session->set('user_choices', $user_choices);

            //クイズが最後かどうかで場合分け
            if ($quiz->getIsLast()) {
                return $this->redirectToRoute('four_play_result', [
                    'four_course_id' => $four_course_id
                    ]);
            } else {
                return $this->redirectToRoute('four_play_quiz', [
                    'four_course_id' => $four_course_id,
                    'quiz_num' => $quiz_num
                    ]);
            }
        }

        return $this->render("FourChoiceQuiz/FourPlay/quiz.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/genre/four/{four_course_id}/play/result", name="four_play_result")
     */
    function resultAction(Request $request, $four_course_id) {
        $session = $request->getSession();

        if ($session->get('selected_course_id') != $four_course_id) {
            $this->addFlash(
                'error',
                '不正なリクエストです'
            );
            return $this->redirectToRoute('four_play_index', [
                'four_course_id' => $four_course_id
            ]);
        }

        //正解とユーザーの選択肢
        $correct_choices = $session->get('correct_choices');
        $user_choices = $session->get('user_choices');

        $quizzes = $this->getDoctrine()->getRepository(FourQuiz::class)->findByFourCourseId($four_course_id);
        //QuizNumでソート 上のDBから持ってくるときにソートさせたほうがいいかも？
        usort($quizzes, function ($a, $b) {
            return ($a->getQuizNum() < $b->getQuizNum()) ? -1 : 1;
        });

        //答え合わせ
        //結果をDBに保存
        $em = $this->getDoctrine()->getManager();
        for ($i = 1; $i <= count($correct_choices); $i++) {
            $results[$i] = new Result;
            $results[$i]->setUserId(1);//////////////////////
            $results[$i]->setDate(date("Y-m-d"));
            $results[$i]->setFourQuizId($quizzes[$i]->getId());
            if ($correct_choices[$i] == $user_choices[$i]) {
                $results[$i]->setResult('correct');
            }
            else {
                $results[$i]->setResult('wrong');
            }
            $em->persist($results[$i]);
        }

        $em->flush();

        //セッションを削除
        $session->remove('correct_choices');
        $session->remove('user_choices');
        $session->remove('selected_four_course_id');

        return $this->render("FourChoiceQuiz/FourPlay/result.html.twig", [
            'four_course_id' => $four_course_id,
            'quizzes' => $quizzes,
            'results' => $results,
        ]);
    }
}