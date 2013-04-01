<?php

namespace Stuoj\Model;

/**
 * ExamProblemRow
 *
 * @uses Pix_Table_Row
 */
class ExamProblemRow extends \Pix_Table_Row
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
        $table = ExamProblem::getTable();
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
 * ExamProblem
 *
 * @uses Pix_Table
 */
class ExamProblem extends \Pix_Table
{
    public $_name = 'exam_problem';
    public $_rowClass = '\\Stuoj\\Model\\ExamProblemRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true, 'unsigned' => true];
        $this->_columns['content'] = ['type' => 'text'];
        $this->_columns['correct_answer'] = ['type' => 'varchar', 'size' => 100];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return ExamProblemRow
     */
    public static function add($data)
    {
        $insert_data = [
            'content' => $data['content'],
            'correct_answer' => $data['correct_answer'],
        ];

        return self::insert($insert_data);
    }
}
