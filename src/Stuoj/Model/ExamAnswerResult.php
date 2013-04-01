<?php

namespace Stuoj\Model;

/**
 * ExamAnswerResultRow
 *
 * @uses Pix_Table_Row
 */
class ExamAnswerResultRow extends \Pix_Table_Row
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
        $table = ExamAnswerResult::getTable();
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
 * ExamAnswerResult
 *
 * @uses Pix_Table
 */
class ExamAnswerResult extends \Pix_Table
{
    public $_name = 'exam_answer_result';
    public $_rowClass = '\\Stuoj\\Model\\ExamAnswerResultRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true, 'unsigned' => true];
        $this->_columns['exam_test_id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['user_id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['exam_question_id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['score'] = ['type' => 'tinyint', 'size' => 4, 'unsigned' => true];
        $this->_columns['status'] = ['type' => 'tinyint', 'size' => 4, 'unsigned' => true];
        $this->_columns['created_at'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];

		$this->_relations['problem'] = ['rel' => 'has_many', 'type' => 'ExamTest', 'foreign_key' => 'id', 'delete' => true];
		$this->_relations['user'] = ['rel' => 'belongs_to', 'type' => 'User', 'foreign_key' => 'user_id'];
		$this->_relations['exam_question'] = ['rel' => 'has_many', 'type' => 'ExamQuestio', 'foreign_key' => 'id', 'delete' => true];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return ExamAnswerResultRow
     */
    public static function add($data)
    {
        $insert_data = [
            'exam_test_id' => $data['exam_test_id'],
            'user_id' => $data['user_id'],
            'exam_question_id' => $data['exam_question_id'],
            'score' => $data['score'],
            'status' => $data['status']
        ];

        return self::insert($insert_data);
    }
}
