<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
    die("Are you hacker?! NO WAY!");

class Templater implements Singleton {

    private static $_instance = null;

    private $_data;
    private $_registry;
    private $_tpl;
    private $_db;
    
    public static function getInstance()
    {
        if(is_null(self::$_instance))
            self::$_instance = new self();
        return self::$_instance;
    }

    function __construct()
    {
        $this->_db = DB::getInstance();
        $this->_registry = Registry::getInstance();
    }

    public function __set($key, $value)
    {
        $this->_data[$key] = $value;
    }

    public function __get($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : '';
    }
    
    public function usePlugin($plugin) {
        $this->_tpl = Templater::getInstance();
        include(MODULES_PLUGINS . $plugin . '.php');
    }

    public function view($tpl_name = null)
    {
        $tpl = $this->_tpl = Templater::getInstance();
        // TODO: checking of the file existence.
        include THEMES . Settings::getTheme() . '/' . $this->_registry->get('body_tpl');
    }

}

?>
