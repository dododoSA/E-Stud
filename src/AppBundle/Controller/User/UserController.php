<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\FourChoiceQuiz\FourResult;
use AppBundle\Form\User\UserRegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class UserController extends Controller {
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request) {
        $form = $this->createForm(UserRegistrationForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getUsername());
            
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );
        }

        return $this->render('User/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/user/{id}", name="user_show")
     */
    public function showAction($id) {
        $user = $this->getUser();
        if ($user->getId() != $id || in_array('ROLE_ADMIN', $user->getRoles())) {
            $this->redirectToRoute('homepage');
        }
        return $this->render('User/show.html.twig');
    }
}