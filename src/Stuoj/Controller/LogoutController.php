<?php

namespace Stuoj\Controller;

class LogoutController extends BaseController
{

    public function indexAction()
    {
        \Pix_Session::clear();
        return $this->redirect('/');
    }
}
