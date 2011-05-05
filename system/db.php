<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class DB implements Singleton {
    
    private static $_instance = null;

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $typename = Settings::getDbType();
        
        include_once SYSTEMS . 'db/' . $typename . '.php';
        $classname = ucfirst($typename);

        self::$_instance = new $classname();
    }

}

?>