<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class SetError {
    
    function __construct($key, $val)
    {
        if(mb_strlen(trim($key), 'UTF-8')) {
            Messages::getInstance()->setMessage(trim($key), trim($val), true);
        }
    }
    
    function __destruct()
    {
        unset($this);
    }
}

?>
