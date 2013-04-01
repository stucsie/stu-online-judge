<?php

namespace Stuoj\Model;

/**
 * ExamScoreResultRow
 *
 * @uses Pix_Table_Row
 */
class ExamScoreResultRow extends \Pix_Table_Row
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
        $table = ExamScoreResult::getTable();
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
 * ExamScoreResult
 *
 * @uses Pix_Table
 */
class ExamScoreResult extends \Pix_Table
{
    public $_name = 'exam_score_result';
    public $_rowClass = '\\Stuoj\\Model\\ExamScoreResultRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true, 'unsigned' => true];
        $this->_columns['exam_test_id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['user_id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['score'] = ['type' => 'tinyint', 'size' => 4, 'unsigned' => true, 'default' => '0'];
        $this->_columns['weight'] = ['type' => 'tinyint', 'size' => 4, 'unsigned' => true, 'default' => '0'];
        $this->_columns['created_at'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];

		$this->_relations['exam_test'] = ['rel' => 'has_many', 'type' => 'ExamTest', 'foreign_key' => 'id', 'delete' => true];
		$this->_relations['user_id'] = ['rel' => 'belongs_to', 'type' => 'User', 'foreign_key' => 'user_id'];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return ExamScoreResultRow
     */
    public static function add($data)
    {
        $insert_data = [
            'exam_test_id' => $data['exam_test_id'],
            'user_id' => $data['user_id'],
            'score' => $data['score'],
            'weight' => $data['weight']
        ];

        return self::insert($insert_data);
    }
}
