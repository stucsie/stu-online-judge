<?php

namespace Stuoj\Model;

use Stuoj\Helper\StatusHelper;

/**
 * SolutionRow
 *
 * @uses Pix_Table_Row
 */
class SolutionRow extends \Pix_Table_Row
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
        $table = Solution::getTable();
        $columns = array_keys($table->_columns);
        $update_data = [];

        foreach ($columns as $col) {
            if (isset($data[$col])) {
                $update_data[$col] = trim($data[$col]);
            }
        }

        parent::update($update_data);
    }

    public function getStatus()
    {
        return StatusHelper::getStatusName($this->status);
    }

    public function isWA()
    {
        return ($this->status == StatusHelper::WA);
    }

    /**
     * getStatusLabel
     *
     * @access public
     * @return string
     */
    public function getStatusLabel()
    {
        $status = StatusHelper::getStatus($this->status);
        return sprintf('<span class="label label-%s">%s</span>', $status['label_class'], $status['slug']);
    }

    /**
     * getLanguageName
     *
     * @access public
     * @return string
     */
    public function getLanguageName()
    {
        $langs = Solution::getAvailableLanguages();
        return array_key_exists($this->language, $langs)
            ? $langs[$this->language]['name'] : '';
    }

    /**
     * getExecuteTimeText
     *
     * @access public
     * @return string 執行時間 e.g. "82ms" or "-"
     */
    public function getExecuteTimeText()
    {
        $t = intval($this->execute_time * 1000);
        return (0 !== $t) ? "{$t}ms" : '-';
    }
}

/**
 * Solution
 *
 * @uses Pix_Table
 */
class Solution extends \Pix_Table
{
    public $_name = 'solution';
    public $_rowClass = '\\Stuoj\\Model\\SolutionRow';

    const LANG_JAVA = 1;
    const LANG_CPP  = 2;

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'auto_increment' => true, 'unsigned' => true];
        $this->_columns['problem_id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['user_id']    = ['type' => 'int', 'size' => 10, 'unsigned' => true];
        $this->_columns['language']   = ['type' => 'tinyint', 'size' => 4];
        $this->_columns['source_code']  = ['type' => 'text'];
        $this->_columns['status']   = ['type' => 'tinyint', 'size' => 4, 'unsigned' => true, 'default' => 0];
        $this->_columns['execute_time'] = ['type' => 'double'];
        $this->_columns['file_name']  = ['type' => 'varchar', 'size' => 255, 'default' => ''];
        $this->_columns['output']  = ['type' => 'text', 'default' => ''];
        $this->_columns['created_at'] = ['type' => 'int', 'size' => 11, 'unsigned' => true];

        $this->_relations['problem'] = ['rel' => 'belongs_to', 'type' => 'Stuoj\Model\Problem', 'foreign_key' => 'problem_id'];
        $this->_relations['user'] = ['rel' => 'belongs_to', 'type' => 'Stuoj\Model\User', 'foreign_key' => 'user_id'];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return SolutionRow
     */
    public static function add($data)
    {
        $insert_data = [
            'problem_id' => intval($data['problem_id']),
            'user_id'    => intval($data['user_id']),
            'language'   => intval($data['language']),
            'source_code'   => strval($data['source_code']),
            'file_name'  => $data['file_name']
        ];

        return self::insert($insert_data);
    }

    /**
     * getAvailableLanguages
     *
     * @static
     * @access public
     * @return array
     */
    public static function getAvailableLanguages()
    {
        return [
            self::LANG_JAVA => ['name' => 'Java', 'slug'  => 'java']
            /*self::LANG_CPP  => ['name' => 'C/C++', 'slug' => 'c_cpp']*/
        ];
    }
}
