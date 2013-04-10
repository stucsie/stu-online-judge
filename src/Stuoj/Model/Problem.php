<?php

namespace Stuoj\Model;

/**
 * ProblemRow
 *
 * @uses Pix_Table_Row
 */
class ProblemRow extends \Pix_Table_Row
{
    public function preInsert()
    {
        $this->created_at = time();
    }

    /**
     * update
     *
     * @param array $data
     * @access public
     * @return void
     */
    public function update($data)
    {
        $table = Problem::getTable();
        $columns = array_keys($table->_columns);
        $update_data = [];

        foreach ($columns as $col) {
            if (isset($data[$col])) {
                $update_data[$col] = trim($data[$col]);
            }
        }

        parent::update($update_data);
    }
}

/**
 * Problem
 *
 * @uses Pix_Table
 */
class Problem extends \Pix_Table
{
    public $_name = 'problem';
    public $_rowClass = '\\Stuoj\\Model\\ProblemRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true, 'auto_increment' => true];
        $this->_columns['title'] = ['type' => 'varchar', 'size' => 255,'default' => ''];
        $this->_columns['content'] = ['type' => 'text', 'default' => ''];
        $this->_columns['input'] = ['type' => 'varchar', 'size' => 255,'default' => ''];
        $this->_columns['output'] = ['type' => 'varchar', 'size' => 255,'default' => ''];
        $this->_columns['sample_input'] = ['type' => 'varchar', 'size' => 255,'default' => ''];
        $this->_columns['sample_output'] = ['type' => 'varchar', 'size' => 255,'default' => ''];

    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return ProblemRow
     */
    public static function add($data)
    {
        $insert_data = [
            'title'       => $data['title'],
            'content'     => $data['content'],
            'input'       => $data['input'],
            'output'      => $data['output'],
            'sample_input' => $data['sample_input'],
            'smaple_output' => $data['sample_output']
        ];

        return self::insert($insert_data);
    }

    /**
     * searchBy 搜尋指定的欄位與值
     *
     * @param string $col
     * @param string $value
     * @static
     * @access public
     * @return ResultSet
     */
    public static function searchBy($col, $value)
    {
        $table = Problem::getTable();
        $columns = array_keys($table->_columns);
        if (! in_array($col, $columns)) {
            throw new InvalidArgumentException(__CLASS__ . ' 沒有這個欄位: ' . $col);
        }

        return self::search([$col => $value]);
    }

    /**
     * getProblemByContent
     *
     * @param string $content
     * @static
     * @access public
     * @return Problem
     */
   public static function getProblemByContent($content)
   {
        return self::getProblemBy('content', $content);
   }

    /**
     * getProblemBySource_code
     *
     * @param string source_code
     * @static
     * @access public
     * @return Problem
     */
   public static function getProblemBySource_code($source_code)
   {
        return self::getProblemBy('source_code', $source_code);
   }


    /**
     * getProblemByAnswer
     *
     * @param string answer
     * @static
     * @access public
     * @return Problem
     */
   public static function getProblemByAnswer($answer)
   {
        return self::getProblemBy('answer', $answer);
   }


    /**
     * getProblemByInput
     *
     * @param string input
     * @static
     * @access public
     * @return Problem
     */
   public static function getProblemByInput($input)
   {
        return self::getProblemBy('input', $input);
   }

    /**
     * getProblemByOutput
     *
     * @param string output
     * @static
     * @access public
     * @return Problem
     */
   public static function getProblemByOutput($output)
   {
        return self::getProblemBy('output', $output);
   }

    /**
     * getProblemBy
     *
     * @param string $field
     * @param string $value
     * @static
     * @access public
     * @return Problem
     */
   public static function getProblemBy($field, $value)
   {
        return self::search([strtolower($field) => trim($value)])->first();
   }

}
