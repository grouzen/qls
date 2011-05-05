<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Sessions implements Singleton {

    private static $_instance = null;

    private $_registry, $_db;
    
    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    function __construct()
    {
        $this->_registry = Registry::getInstance();
        $this->_db = DB::getInstance();
    }
    
    function start()
    {
        session_start();
        
        $this->_registry->set('remote_addr', $_SERVER['REMOTE_ADDR']);

        if(isset($_COOKIE['PHPSESSID'])) {
            $this->_registry->set('phpsessid', $_COOKIE['PHPSESSID']);
            $this->_updateOnlineStat();
        }
        
        $this->_writeVisitorsStat();

        setcookie('support', 1, time() + Settings::getCookieExpire());
        
        if(isset($_COOKIE['support']) && (!isset($_COOKIE['remember']) || !isset($_SESSION['login']))) {
            $query = array('controller' => null,
                           'action' => null,
                           'params' => null);
            if(isset($_GET['route'])) {
                $query = Router::getInstance()->encodeRoute($_GET['route']);
                $this->logout($query);
            } else {
                $this->logout($query);
            }
        }
        
    }

    private function _updateOnlineStat()
    {
        $lifetime = 5 * 60;

        $this->_db->query("DELETE FROM online_stat WHERE date < " . (time() - $lifetime));

        $res = $this->_db->query("SELECT * FROM online_stat WHERE sessid = '" . $this->_registry->get('phpsessid') . "'");
        if($this->_db->num_rows($res)) {
            $this->_db->query("UPDATE online_stat SET date = " . time() . " WHERE sessid = '" . $this->_registry->get('phpsessid') . "' LIMIT 1");
        } else {
            $this->_db->query("INSERT INTO online_stat (date, sessid) VALUES (" . time() . ", '" . $this->_registry->get('phpsessid') . "')");
        }
    }
    
    private function _writeVisitorsStat()
    {
        $current_date = date('Y-m-d', time());
        $current_day_start = strtotime($current_date);
        $current_day_end = $current_day_start + 86400;
        
        $res_visitors_stat = $this->_db->query("SELECT * FROM visitors_stat WHERE date >= $current_day_start AND date < $current_day_end AND ip = '" .
                                               $this->_registry->get('remote_addr') . "'");
        if(!$this->_db->num_rows($res_visitors_stat)) {
            $this->_db->query("INSERT INTO visitors_stat (date, ip) VALUES (" . time() . ", '" . $this->_registry->get('remote_addr') . "')");
        }
    }
    
    public function isPassword($password)
    {
        return preg_match('/^[a-zA-Z0-9_\-\.+=*&%$#@!,]*$/', $password);
    }
    
    public function isLogin($login)
    {
        return preg_match('/^[a-zA-Z0-9_\-\.]+$/', $login);
    }
    
    public function login($query)
    {
        $route = Router::getInstance()->decodeRoute($query);
        
        Router::getInstance()->redirect(Settings::getAddressSite() . $route);
    }

    public function logout($query)
    {
        session_unset();
        session_destroy();
        session_start();

        $_SESSION = array();
        $_SESSION['login'] = 'guest';
        $_SESSION['role'] = 'guest';
        $_SESSION['name'] = 'Гость';

        setcookie('remember', 1, time() + Settings::getCookieExpire());

        $route = Router::getInstance()->decodeRoute($query);
        Router::getInstance()->redirect(Settings::getAddressSite() . $route);
    }
}

?>
