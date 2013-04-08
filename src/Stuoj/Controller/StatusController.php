<?php

namespace Stuoj\Controller;

use Stuoj\Model\Problem;
use Stuoj\Model\Solution;
use Stuoj\Helper\StatusHelper;

class StatusController extends BaseController
{

    public function indexAction()
    {
        $v = $this->view;
        $v->solutions = Solution::search(1);
        //return $this->redraw('/problem/index.phtml');
    }

}
