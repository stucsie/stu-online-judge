<?php

namespace Stuoj\Controller;

use PasswordLib;
use Stuoj\Service\PasswordAuthenticationService;
use Stuoj\Exception\AlertException;

class LoginController extends BaseController
{

    public function indexAction()
    {
        if ($this->isGet()) {
            return;
        }

        $account  = isset($_POST['account'])  ? $_POST['account'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // 不分大小寫
        $account = strtolower($account);

        $pas = new PasswordAuthenticationService($account, $password);
        $lib = new PasswordLib\PasswordLib();
        $pas->setPasswordLib($lib);

        $user = $pas->getUser();
        if (! $user) {
            throw new AlertException('帳號或密碼錯誤，請再次確認', '/login');
        }
        var_dump($user->toArray());
        $sess = $this->getSession();

        $sess->user = $user;
        $sess->account = $user->account;
        $sess->email = $user->email;

        return $this->redirect('/index');
    }
}
