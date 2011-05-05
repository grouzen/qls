<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Registry implements Singleton {

    private static $_instance = null;

    private $_vars = array();

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    public function get($key)
    {
        try {
            if(!isset($this->_vars[$key])) {
                throw new Exception('Variable not exists: ' . $key);
            } else {
                return $this->_vars[$key];
            }
            
        } catch (Exception $e) {
            echo $this->_getExceptionError($e);
        }
    }

    public function set($key, $value)
    {
        try {
            if(isset($this->_vars[$key])) {
                throw new Exception('Variable already exists: ' . $key);
            } else {
                $this->_vars[$key] = $value;
            }
        } catch(Exception $e) {
            echo $this->_getExceptionError($e);
        }

    }

    public function delete($key)
    {
        try {
            if(!isset($this->_vars[$key])) {
                throw new Exception('Variable doesn\'t exists');
            } else {
                unset($this->_vars[$key]);
            }
        } catch(Exception $e) {
            echo $this->_getExceptionError($e);
        }
    }

    public function exists($key)
    {
        return (isset($this->_vars[$key])) ? true : false;
    }

    private function _getExceptionError($e)
    {
        return $e->getTraceAsString() . '<br />' . $e->getMessage() . '<br />';
    }
}

?>
