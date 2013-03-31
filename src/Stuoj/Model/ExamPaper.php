<?php

namespace Stuoj\Model;

/**
 * ExamPaperRow
 *
 * @uses Pix_Table_Row
 */
class ExamPaperRow extends \Pix_Table_Row
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
        $table = ExamPaper::getTable();
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
 * ExamPaper
 *
 * @uses Pix_Table
 */
class ExamPaper extends \Pix_Table
{
    public $_name = 'ExamPaper';
    public $_rowClass = '\\Stuoj\\Model\\ExamPaperRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true];
        $this->_columns['exam_password'] = ['type' => 'int', 'size' => 5];
        $this->_columns['start_at'] = ['type' => 'int', 'size' => 10];
        $this->_columns['end_at'] = ['type' => 'tinyint', 'size' => 4];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return ExamPaperRow
     */
    public static function add($data)
    {
        $insert_data = [
            'exam_password' => $data['exam_password'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at']
        ];

        return self::insert($insert_data);
    }
}
