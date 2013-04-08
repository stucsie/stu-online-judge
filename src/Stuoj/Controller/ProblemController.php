<?php

namespace Stuoj\Controller;

use Stuoj\Model\Problem;
use Stuoj\Model\Solution;

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

    /**
     * solveAction 解題頁面
     *
     * @access public
     * @return void
     */
    public function solveAction()
    {
        $this->checkLogin();
        $pid = $this->segment(1);
        $p = Problem::find($pid);
        if (! $p) {
            throw new AlertException('沒有這個題目', '/problem/');
        }

        if ($this->isPost()) {
            $code  = isset($_POST['source_code'])  ? $_POST['source_code'] : '';
            $data = [
                'problem_id' => $pid,
                'user_id' => $this->getUser()->id,
                'language' => 1,
                'source_code' => $code,
                'execute_time' => 0
            ];
            $solution = Solution::add($data);
            $args = ['code' => $code, 'solution_id' => $solution->id];
            \Resque::enqueue('default', 'Stuoj\Job\JudgeJob', $args);

            $this->redirect('/status');
        }
        $this->view->problem = $p;

    }
}
