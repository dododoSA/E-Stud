<?php

namespace AppBundle\Security;

use AppBundle\Form\Security\LoginForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator {

    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

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
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        $data = $form->getData();

        //validationは別でやる
        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        
    }

    protected function getLoginUrl()
    {
        
    }

    protected function getDefaultSuccessRedirectUrl()
    {

    }
}