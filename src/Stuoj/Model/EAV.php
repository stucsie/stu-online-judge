<?php

/**
 * EAV
 *
 * @uses Pix_Table
 */
class EAV extends Pix_Table
{
    /**
     * init
     *
     * @access public
     * @return void
     */
    public function init()
    {
        $this->_name = 'EAV';
        $this->_primary = 'key';

        $this->_columns['key'] = ['type' => 'varchar', 'size' => 255];
        $this->_columns['value'] = ['type' => 'text'];
    }

    /**
     * set
     *
     * @param string $key
     * @param string $value
     * @static
     * @access public
     * @return void
     */
    public static function set($key, $value)
    {
        $data = ['key' => $key, 'value' => $value];

        if ($EAV = self::search(['key' => $key])->first()) {
            $EAV->update($data);
        } else {
            self::insert($data);
        }
    }

    /**
     * get
     *
     * @param string $key
     * @static
     * @access public
     * @return string
     */
    public static function get($key)
    {
        return self::search(['key' => $key])->first()->value;
    }

    /**
     * delete
     *
     * @param string $key
     * @static
     * @access public
     * @return Pix_Table_Row
     */
    public static function delete($key)
    {
        return self::search(['key' => $key])->first()->delete();
    }
}
