<?php

namespace Stuoj\Model;

/**
 * ExamTestRow
 *
 * @uses Pix_Table_Row
 */
class ExamTestRow extends \Pix_Table_Row
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
        $table = ExamTest::getTable();
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
 * ExamTest
 *
 * @uses Pix_Table
 */
class ExamTest extends \Pix_Table
{
    public $_name = 'exam_test';
    public $_rowClass = '\\Stuoj\\Model\\ExamTestRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true, 'unsigned' => true];
        $this->_columns['title'] = ['type' => 'varchar', 'size' => 50];
        $this->_columns['auth_code'] = ['type' => 'int', 'size' => 5, 'unsigned' => true];
        $this->_columns['start_at'] = ['type' => 'int', 'size' => 11, 'unsigned' => true];
        $this->_columns['end_at'] = ['type' => 'int', 'size' => 11, 'unsigned' => true];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return ExamTestRow
     */
    public static function add($data)
    {
        $insert_data = [
            'title' => $data['title'],
            'auth_code' => $data['auth_code'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at']
        ];

        return self::insert($insert_data);
    }
}
