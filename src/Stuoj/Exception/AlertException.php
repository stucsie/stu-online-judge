<?php

namespace Stuoj\Exception;

/**
 * AlertException
 *
 */
class AlertException extends \Exception
{
    /**
     * url
     *
     * @var string
     * @access protected
     */
    protected $url;

    /**
     * __construct
     *
     * @param string $message
     * @param string $url
     * @access public
     * @return void
     */
    public function __construct($message, $url = null)
    {
        parent::__construct($message);
        $this->url = $url;
    }

    /**
     * getURL
     *
     * @access public
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }
}