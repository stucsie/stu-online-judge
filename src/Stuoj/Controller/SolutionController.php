<?php

namespace Stuoj\Controller;

use Stuoj\Model\Problem;
use Stuoj\Model\Solution;
use Stuoj\Helper\StatusHelper;
use Stuoj\Exception\AlertException;

class SolutionController extends BaseController
{

    public function browseAction()
    {
        $v = $this->view;
        $sid = intval($this->segment(1));
        if (! $sol = Solution::find($sid)) {
            return $this->noview();
        }

        // 只開放觀看 WA 的執行結果
        if (! $sol->isWA()) {
            return $this->noview();
        }

        $v->solution = $sol;
    }

}
