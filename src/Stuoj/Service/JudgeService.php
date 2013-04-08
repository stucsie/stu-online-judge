<?php

namespace Stuoj\Service;

class JudgeService
{
    private $timeOut = 0;
    private $codeFile = '';
    private $answerFilePath = '';
    private $compilingError = '';
    private $encoding = 'utf-8';
    private $runOutput='';

    public function __construct()
    {
    }

    /**
     * setAnswerFile
     *
     * @param mixed $file_path_name
     * @access public
     * @return void
     */
    public function setAnswerFile($file_path_name)
    {
        $this->answerFilePath = $file_path_name;
    }

    /**
     * setCodeFile
     *
     * @param mixed $file_path_name
     * @access public
     * @return void
     */
    public function setCodeFile($file_path_name)
    {
        $this->codeFile = $file_path_name;
    }

    /**
     * setTimeLimit
     *
     * @param mixed $second
     * @access public
     * @return void
     */
    public function setTimeLimit($second)
    {
        $this->timeOut = $second;
    }

    /**
     * setOutputPath
     *
     * @param mixed $file_path_name
     * @access public
     * @return void
     */
    public function setOutputPath($file_path_name)
    {
        $this->answerFilePath = $file_path_name;
    }

    /**
     * getCompilingError
     *
     * @access public
     * @return void
     */
    public function getCompilingError()
    {
        return $this->commilingError;
    }

    /**
     * compiling
     * 使用此方法前必須先調用 setCodeFile 方法
     *
     * @access public
     * @return void
     */
    public function compiling()
    {
        if (empty($this->codeFile)) {
            throw new \Exception('Not yet specified file');
        }

        $file = $this->codeFile;
        $encoding = $this->encoding;

        if (!is_file($file)) {
           throw new \Exception('File not found');
        }

        $command = "javac -encoding $encoding -cp . $file 2>&1";
        $compile_result_error = shell_exec($command);
        file_put_contents(__DIR__ . '/error.log', $compile_result_error);
        $this->compilingError = $compile_result_error;
    }

    public function getRunOutput()
    {
	return $this->runOutput;
    }


    /**
     * run
     * 執行程式，若 compiling 沒有成功則無法執行.
     * @param mixed $input_file_path 測資檔案位子，若沒有空值即可
     * @access public
     * @return void
     */
    public function run($input_file_path = null)
    {

        $file = basename($this->codeFile);
        $path = str_replace($file, '', $this->codeFile);

        // 判斷是否有編譯成功
        if (!is_file($file.'.class')) {
            throw new \Exception('Not yet compiled or compiled error');
        }

        $timeOut = $this->timeOut;
        $command = "timeout $timeOut java -cp $path $file";

        if ($input_file_path) {
            $command .= " < $input_file_path";
        }

        $this->runOutput = shell_exec($command);
    }

    /**
     * checkAnswer
     * 判斷答案是否正確
     * @access public
     * @return boolean 正確為 true
     */
    public function checkAnswer()
    {
	return file_get_contents($this->answerFilePath) == $this->runOutput;
    }
}