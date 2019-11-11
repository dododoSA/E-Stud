<?php

namespace AppBundle\Controller\Result;

use AppBundle\Entity\FourChoiceQuiz\FourResult;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends Controller {
    /**
     * @Route("/user/{user_id}/four_quiz_result", name="four_result")
     */
    public function fourResultAction($user_id) {
        $user = $this->getUser();
        if ($user->getId() != $user_id || in_array('ROLE_ADMIN', $user->getRoles())) {
            $this->redirectToRoute('homepage');
        }
        $results = $this->getDoctrine()->getRepository(FourResult::class)->findByUserId($user->getId());
        
        dump($results[0]->getFourQuiz());
        return $this->render('Result/four.html.twig',[
            'results' => $results
        ]);
    }

    /**
     * @Route("")
     */
}