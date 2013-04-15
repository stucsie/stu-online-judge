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
            $lang  = isset($_POST['language'])  ? intval($_POST['language']) : '';
            $data = [
                'problem_id' => $pid,
                'user_id' => $this->getUser()->id,
                'language' => $lang,
                'source_code' => $code,
                'execute_time' => 0
            ];
            $solution = Solution::add($data);
            $args = ['code' => $code, 'solution_id' => $solution->id];
            \Resque::enqueue('default', 'Stuoj\Job\JudgeJob', $args);

            $this->redirect('/status');
        }
        $this->view->problem = $p;
        $this->view->languages = Solution::getAvailableLanguages();
    }

    /**
     * addAction 新增題目頁面
     *
     * @access public
     * @return void
     */

    public function addAction()
    {
        $this->checkLogin();

        if (! $this->getUser()->admin) {
            /* 這個使用者沒有 admin 轉回首頁 */
            $this->redirect('/');
        }

        if ($this->isPost()) {
            $title  = isset($_POST['title'])  ? $_POST['title'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $input = isset($_POST['input']) ? $_POST['input'] : '';
            $output = isset($_POST['output']) ? $_POST['output'] : '';
            $sample_input = isset($_POST['sample_input']) ? $_POST['sample_input'] : '';
            $sample_output = isset($_POST['sample_output']) ? $_POST['sample_output'] : '';

            $data = [
                'title' => $title,
                'content' => $content,
                'input' => $input,
                'output' => $output,
                'sample_input' => $sample_input,
                'sample_output' => $sample_output
            ];

            $problem = Problem::add($data);

            $this->redirect('/problem/list');
        }
    }
}
