<?php

namespace Stuoj\Model;

/**
 * AppendixRow
 *
 * @uses Pix_Table_Row
 */
class AppendixRow extends \Pix_Table_Row
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
        $table = Appendix::getTable();
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
 * Appendix
 *
 * @uses Pix_Table
 */
class Appendix extends \Pix_Table
{
    public $_name = 'Appendix';
    public $_rowClass = '\\Stuoj\\Model\\AppendixRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true];
        $this->_columns['problem_id'] = ['type' => 'int', 'size' => 10];
        $this->_columns['file_name'] = ['type' => 'varchar', 'size' => 255];
        $this->_columns['created_at'] = ['type' => 'int', 'size' => 11];

		$this->_relations['problem'] = ['rel' => 'has_many', 'type' => 'Problem', 'foreign_key' => 'id', 'delete' => true];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return AppendixRow
     */
    public static function add($data)
    {
        $insert_data = [
            'problem_id' => $data['problem_id'],
            'file_name' => $data['file_name']
        ];

        return self::insert($insert_data);
    }
}
