<?php

namespace AppBundle\Controller\Security;

use AppBundle\Form\Security\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller {
    /**
     * @Route("/login", name="login")
     */
    public function loginAction() {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername
        ]);

        return $this->render(
            'security/login.html.twig',
            [
                'error' => $error,
                'form' => $form->createView()
            ]
            );
    }
}