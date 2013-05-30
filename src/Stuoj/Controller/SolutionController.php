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
            throw new AlertException('不存在的解題編號', '/status');
            return $this->noview();
        }

        // 只開放觀看 WA 的執行結果

        if (! $sol->isWA()) {
            throw new AlertException('只開放觀看 WA 的執行結果喔', '/status');
            return $this->noview();
        }
        $sol->output = '暫時不開放WA詳細資料';
        $v->solution = $sol;
    }

}
