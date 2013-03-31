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
    public $_name = 'ExamProblem';
    public $_rowClass = '\\Stuoj\\Model\\ExamProblemRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true];
        $this->_columns['exap_paper_id'] = ['type' => 'int', 'size' => 10];
        $this->_columns['problem_id'] = ['type' => 'int', 'size' => 10];
        $this->_columns['fraction'] = ['type' => 'tinyint', 'size' => 4, 'default' => '0'];

		$this->_relations['problem'] = ['rel' => 'has_many', 'type' => 'Problem', 'foreign_key' => 'id', 'delete' => true];
		$this->_relations['exam_paper'] = ['rel' => 'has_many', 'type' => 'ExamPaper', 'foreign_key' => 'id', 'delete' => true];
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
            'exam_paper_id' => $data['exam_paper_id'],
            'problem_id' => $data['problem_id'],
            'fraction' => $data['fraction']
        ];

        return self::insert($insert_data);
    }
}
