<?php

namespace Stuoj\Service;

use Stuoj\Model\User;
use PasswordLib;
/**
 * PasswordAuthenticationService
 *
 * @uses PasswordLib\PasswordLib
 */
class PasswordAuthenticationService
{
    protected $username, $password;

    /**
     * passwordLib
     *
     * @var PasswordLib\PasswordLib
     * @access protected
     */
    protected $passwordLib;

    /**
     * __construct
     *
     * @param string $username
     * @param string $password
     * @access public
     * @return void
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function setPasswordLib(PasswordLib\PasswordLib $lib)
    {
        $this->passwordLib = $lib;
    }

    /**
     * __call
     *
     * @param string $name
     * @param array $args
     * @access public
     * @return void
     */
    public function __call($name, $args)
    {
        throw new BadMethodCallException(__CLASS__ . " 沒有 $name 這個 method");
    }

    /**
     * getUser
     *
     * @access public
     * @return UserRow|null
     */
    public function getUser()
    {
        $u = User::getUserByAccount($this->username);

        if ($u && $this->authenticate($u)) {
            return $u;
        }

        return null;
    }

    /**
     * authenticate
     *
     * @param mixed $user
     * @access private
     * @return boolean
     */
    private function authenticate($user)
    {
        return $this->passwordLib->verifyPasswordHash($this->password, $user->password);
    }

}
