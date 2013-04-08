<?php

namespace Stuoj\Helper;

/**
 * StatusHelper
 *
 * @uses \Pix_Helper
 */
class StatusHelper extends \Pix_Helper
{
    const UNKNOWN = 0;
    const AC  = 1;
    const NA  = 2;
    const WA  = 3;
    const TLE = 4;
    const MLE = 5;
    const OLE = 6;
    const RE  = 7;
    const RF  = 8;
    const CE  = 9;
    const SE  = 10;

    static $STATUS_NAMES = array(
        ['full' => 'Unknown',      'slug' => 'UN', 'label_class' => ''],
        ['full' => 'Accepted',     'slug' => 'AC', 'label_class' => 'success'],
        ['full' => 'Not Accept',   'slug' => 'NA', 'label_class' => 'important'],
        ['full' => 'Wrong Answer', 'slug' => 'WA', 'label_class' => 'important'],
        ['full' => 'Time Limit Exceeded',   'slug' => 'TLE', 'label_class' => 'warning'],
        ['full' => 'Memory Limit Exceeded', 'slug' => 'MLE', 'label_class' => 'warning'],
        ['full' => 'Output Limit Exceeded', 'slug' => 'OLE', 'label_class' => 'warning'],
        ['full' => 'Runtime Error',         'slug' => 'RE', 'label_class' => 'inverse'],
        ['full' => 'Restricted Function',   'slug' => 'RF', 'label_class' => 'inverse'],
        ['full' => 'Compile Error',         'slug' => 'CE', 'label_class' => 'inverse'],
        ['full' => 'System Error',          'slug' => 'SE', 'label_class' => 'inverse']
    );

    /**
     * getStatus
     *
     * @param integer $status_id
     * @static
     * @access public
     * @return array
     */
    public static function getStatus($status_id)
    {
        return $status_id < count(self::$STATUS_NAMES)
            ? self::$STATUS_NAMES[$status_id] : '';
    }

    /**
     * getStatusName
     *
     * @param integer $status_id
     * @static
     * @access public
     * @return string
     */
    public static function getStatusName($status_id)
    {
        return self::getStatus($status_id)['full'];
    }

    /**
     * getStatusSlug 取得狀態縮寫 e.g. "AC", "WA"
     *
     * @param integer $status_id
     * @static
     * @access public
     * @return string
     */
    public static function getStatusSlug($status_id)
    {
        return self::getStatus($status_id)['slug'];
    }
}