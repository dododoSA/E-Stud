<?php

namespace AppBundle\Controller\User;

use AppBundle\Form\User\UserRegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request) {
        $form = $this->createForm(UserRegistrationForm::class);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}