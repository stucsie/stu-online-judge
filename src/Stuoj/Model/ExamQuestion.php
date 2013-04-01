<?php

namespace Stuoj\Model;

/**
 * ExamQuestionRow
 *
 * @uses Pix_Table_Row
 */
class ExamQuestionRow extends \Pix_Table_Row
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
        $table = ExamQuestion::getTable();
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
 * ExamQuestion
 *
 * @uses Pix_Table
 */
class ExamQuestion extends \Pix_Table
{
    public $_name = 'exam_question';
    public $_rowClass = '\\Stuoj\\Model\\ExamQuestionRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true, 'unsigned' => true];
        $this->_columns['exam_test_id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['exam_problem_id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['point'] = ['type' => 'int', 'size' => 5, 'unsigned' => true, 'default' => '0'];

		$this->_relations['exam_test'] = ['rel' => 'has_many', 'type' => 'ExamTest', 'foreign_key' => 'id', 'delete' => true];
		$this->_relations['exam_problem'] = ['rel' => 'has_many', 'type' => 'ExamProblem', 'foreign_key' => 'id'];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return ExamQuestionRow
     */
    public static function add($data)
    {
        $insert_data = [
            'exam_test_id' => $data['exam_test_id'],
            'exam_problem_id' => $data['exam_problem_id'],
            'point' => $data['point']
        ];

        return self::insert($insert_data);
    }
}
