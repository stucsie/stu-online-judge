<?php
namespace Stuoj\Job;

use Stuoj\Model\EAV;
use Stuoj\Model\Solution;
use Stuoj\Service\JudgeService;
use Stuoj\Helper\StatusHelper;

class JudgeJob
{
    public function perform()
    {
        $sol_id = intval($this->args['solution_id']);
        $sol = Solution::find($sol_id);
        if (! $sol) {
            return ;
        }

        $ts = time();
        $code_path = '/tmp/stuoj-user-codes';
        $filename = 'JAVA' . $ts . '.java';
        $sol->update(['file_name' => $filename]);

        // Replace user's custom Java class name to 'JAVA{timestamp}'
        $pattern = '/(public)\s+(class)\s+([a-zA-Z0-9_]+)/i';
        $user_code = preg_replace($pattern, '$1 $2 JAVA' .$ts , $this->args['code']);
        file_put_contents($code_path . '/' . $filename, $user_code);

        $input_data_file = $code_path . '/' . 'p' . $sol->problem->id . '.in';
        file_put_contents($input_data_file, $sol->problem->input);

        $ans_file = $code_path . '/' . 'p' . $sol->problem->id . '.ans';
        file_put_contents($ans_file, $sol->problem->output);

        $judge = new JudgeService();
        $code_file = $code_path . '/' . $filename;
        $judge->setCodeFile($code_file);
        $judge->setTimeLimit(5);
        $judge->compiling();

        if ($compi_err = $judge->getCompilingError()) {
            $sol->update([
                'status' => StatusHelper::CE,
                'execute_time' => 0,
                'output' => $compi_err
            ]);
            return;
        }

        $start_time = $this->getMicrotime();
        $judge->run($input_data_file);
        $end_time = $this->getMicrotime();
        $judge->setAnswerFile($ans_file);
        $sol->update([
            'status' => ($judge->checkAnswer()) ? StatusHelper::AC : StatusHelper::WA,
            'execute_time' => round($end_time - $start_time, 7),
            'output' => $judge->getRunOutput()
        ]);

    }

    private function getMicrotime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}