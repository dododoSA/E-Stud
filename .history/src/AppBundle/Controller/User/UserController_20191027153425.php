<?php

namespace AppBundle\Controller\User;

use AppBundle\Form\User\UserRegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller {
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request) {
        $form = $this->createForm(UserRegistrationForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setUsername($request->request->get('user_registration_form')["username"]);
            dump($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getUsername());
            return $this->redirectToRoute('homepage');
        }

        return $this->render('User/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}