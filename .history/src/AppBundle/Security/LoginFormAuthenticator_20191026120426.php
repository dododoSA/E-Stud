<?php

namespace AppBundle\Security;

use AppBundle\Form\Security\LoginForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator {
    private $formFactory;

    private $em;

    private $router;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->$em = $em;
        $this->$router = $router;
    }

    //最初に呼ばれる
    public function getCredentials(Request $request)
    {
        //ログインフォームからpostメソッドでsubmitされたかどうか
        //$request->getPathInfo() == '/login'   →   $request->attributes->get('__route') === 'login'   でも可
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');
        if (!$isLoginSubmit) {
            //もしgetCredentialsからnullを返したらsymfonyはユーザー認証を飛ばす
            return;
        }

        //createformbuilderと何が違うんだろう ← formfactoryをかんたんに使えるようにしたやつ
        //Controllerをextendsしてないから↑は使えないあとのemについても同様
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        $data = $form->getData();

        //validationは別でやる
        return $data;
    }

    //第一引数にはgetCredentialsでreturnされた値が入る
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        return $this->em->getRepository('AppBundle:User')->findOneBy(['username' => $username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        //誰でもこのpwでログインできる
        if ($password == 'iliketurtles') {
            return true;
        }

        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }
}