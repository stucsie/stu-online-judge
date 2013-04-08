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
        'Unknown',
        'Accepted',
        'Not Accept',
        'Wrong Answer',
        'Time Limit Exceeded',
        'Memory Limit Exceeded',
        'Output Limit Exceeded',
        'Runtime Error',
        'Restricted Function',
        'Compile Error',
        'System Error',
    );

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
        return $status_id < count(self::$STATUS_NAMES)
            ? self::$STATUS_NAMES[$status_id] : '';
    }
}