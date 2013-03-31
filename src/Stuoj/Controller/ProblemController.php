<?php

namespace Stuoj\Controller;

use Stuoj\Model\Problem;

class ProblemController extends BaseController
{

    public function indexAction()
    {
        return $this->redirect('/problem/list');
    }

    public function listAction()
    {
        $v = $this->view;

        $v->problems = Problem::search(1);
        return $this->redraw('/problem/index.phtml');
    }

    public function browseAction()
    {
        $pid = $this->segment(1);
        $p = Problem::find($pid);
        if (! $p) {
            throw new AlertException('沒有這個題目', '/problem/');
        }

        $this->view->problem = $p;
    }
}
