<?php

namespace AppBundle\Controller\Result;

use AppBundle\Entity\FourChoiceQuiz\FourResult;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends Controller {
    /**
     * @Route("/user/four_quiz_result", name="four_result")
     */
    public function fourResultAction() {
        $user = $this->getUser();
        $results = $this->getDoctrine()->getRepository(FourResult::class)->findByUserId($user->getId());

        return $this->render('Result/four.html.twig',[
            'results' => $results
        ]);
    }

    /**
     * @Route("")
     */
}