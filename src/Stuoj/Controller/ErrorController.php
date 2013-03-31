<?php

namespace Stuoj\Controller;

use Stuoj\Exception\AlertException;

class ErrorController extends \Pix_Controller
{
    public function errorAction()
    {
    $exception = $this->view->exception;

        if ($exception instanceof ErrorMessage) {
            $session = $this->getSession();
            $session->error_message = $exception->getMessage();
            return $this->redirect($exception->getURL());
        } elseif ($exception instanceof InfoMessage) {
            $session = $this->getSession();
            $session->info_message = $exception->getMessage();
            return $this->redirect($exception->getURL());
        } elseif ($exception instanceof JsonException) {
            $ret = array(
                'error' => true,
                'message' => $exception->getMessage()
            );
        return $this->json($ret);
        } elseif ($exception instanceof AlertException) {
        $this->view->message = $exception->getMessage();
        $this->view->url = $exception->getURL();
        return $this->redraw('/error/error_popup.phtml');
    } elseif ($exception instanceof Pix_Controller_Dispatcher_Exception) {
            header("HTTP/1.0 404", 404);
            echo '404 Not Found';
        return $this->noview();
    } elseif ($exception instanceof ConfirmException) {
        $this->view->exception = $exception;
        return $this->redraw('/error/error_popup.phtml');
    } else {
            header("HTTP/1.0 500", 500);
            trigger_error($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ": " . $exception->getMessage(), E_USER_WARNING);
    }
    }
}