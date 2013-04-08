<?php

namespace Stuoj\Controller;

use Stuoj\Model\User;

class BaseController extends \Pix_Controller
{
    protected $perm_service;

    public function init()
    {
        if ('ErrorController' === get_class($this)) {
            return;
        }

        $session = $this->getSession();

        if ($this->isGet()) {
            $view = $this->view;

            $view->controllerName = $this->getControllerName();
            $view->actionName = $this->getActionName();
            $view->csrfToken = $view->sToken = $session->sToken;
            if ($session->account) {
                $view->account = $session->account;
            }
        }

        if (! $this->isGet() and $_REQUEST['sToken'] != $session->sToken) {
            header('Status: 403 Forbidden');
            return $this->noview();
        }

    }

    public function getSession()
    {
        if (!$this->session) {
            $this->session = new \Pix_Session();
        }

        $session = $this->session;

        if (!$session->sToken) {
            $session->sToken = base64_encode(hash('sha256', mt_rand(), TRUE));
        }

        return $session;
    }

    public function getUser()
    {
        $account = $this->getSession()->account;
        return User::getUserByAccount($account);
    }

    public function segment($index)
    {
        $parts = explode('/', $this->getURI());

        $index += 2;
        if (array_key_exists($index, $parts)) {
            return $parts[$index];
        }
        return null;
    }

    public function checkLogin()
    {
        $session = $this->getSession();

        if (!$session->account) {
            return $this->redirect('/login?done=' . urlencode($_SERVER['REQUEST_URI']));
        }

        $this->view->account = $session->account;
    }
}