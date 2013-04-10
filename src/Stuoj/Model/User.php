<?php

namespace Stuoj\Model;

/**
 * UserRow
 *
 * @uses Pix_Table_Row
 */
class UserRow extends \Pix_Table_Row
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
        $table = User::getTable();
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
 * User
 *
 * @uses Pix_Table
 */
class User extends \Pix_Table
{
    public $_name = 'user';
    public $_rowClass = '\\Stuoj\\Model\\UserRow';

    /**
     * @codeCoverageIgnore
     */
    public function init()
    {
        $this->_primary = 'id';

        $this->_columns['id'] = ['type' => 'int', 'size' => 10, 'unsigned' => true, 'auto_increment' => true];
        $this->_columns['account']      = ['type' => 'varchar', 'size' => 20,  'default' => ''];
        $this->_columns['password']     = ['type' => 'varchar', 'size' => 255, 'default' => ''];
        $this->_columns['name']         = ['type' => 'varchar', 'size' => 50,  'default' => ''];
        $this->_columns['email']        = ['type' => 'varchar', 'size' => 255, 'default' => ''];
        $this->_columns['created_at'] = ['type' => 'int', 'size' => 11, 'unsigned' => true];

        $this->_relations['admin'] = ['rel' => 'has_one', 'type' => 'Stuoj\Model\Admin', 'foreign_key' => 'id'];

        $this->addIndex('email', ['email'], 'unique');
        $this->addIndex('account', ['account'], 'unique');

    }

   /**
    * validate
    *
    * @param $data array
    * @static
    * @access public
    * @return array [boolean, string]
    */
    public static function validate($data)
    {
        $error_msgs = [];
        $email = trim($data['email']);
        $pass = $data['pass'];
        $re_pass = $data['re_pass'];

        if ('' === $email) {
            $error_msgs['email'] = '請填寫 Email';
        } elseif (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msgs['email'] = 'Email 格式不正確';
        }

        if (count($error_msgs)) {
            return [false, $error_msgs];
        }

        return [true, 'success'];
    }

    /**
     * add
     *
     * @param array $data
     * @static
     * @access public
     * @return void
     */
    public static function add($data)
    {
        $insert_data = [
            'account'  => $data['account'],
            'password' => $data['password'],
            'name'     => $data['name'],
            'email'    => $data['email']
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
        $table = User::getTable();
        $columns = array_keys($table->_columns);
        if (! in_array($col, $columns)) {
            throw new InvalidArgumentException(__CLASS__ . ' 沒有這個欄位: ' . $col);
        }

        return self::search([$col => $value]);
    }

    /**
     * getUserByAccount
     *
     * @param string $account
     * @static
     * @access public
     * @return User
     */
    public static function getUserByAccount($account)
    {
        return self::getUserBy('account', $account);
    }

    /**
     * getUserByEmail
     *
     * @param string $email
     * @static
     * @access public
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return self::getUserBy('email', $email);
    }

    /**
     * getUserByName
     *
     * @param string $name
     * @static
     * @access public
     * @return User
     */
    public static function getUserByName($name)
    {
        return self::getUserBy('name', $name);
    }

    /**
     * getUserBy
     *
     * @param string $field
     * @param string $value
     * @static
     * @access public
     * @return User
     */
    public static function getUserBy($field, $value)
    {
        return self::search([strtolower($field) => trim($value)])->first();
    }

}
