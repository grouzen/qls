<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Controller_Gamezone implements Singleton {

    private static $_instance = null;

    private $_tpl;

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    function __construct()
    {
        $this->_tpl = Templater::getInstance();
    }

    public function index($params = null) {
        $this->_tpl->view();
    }

}

?>
