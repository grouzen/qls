<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

include_once SYSTEMS . '/messages/setlogmessage.php';
include_once SYSTEMS . '/messages/seterror.php';
include_once SYSTEMS . '/messages/setmessage.php';

class Messages implements Singleton {

    private static $_instance = null;

    private static $_messages = array();
    
    private $_db;

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    function __construct()
    {
        $this->_db = DB::getInstance();
    }
    
    public function getMessage($key, $error = false)
    {
        /*
        $type = $error ? 'errors' : 'messages';
        
        if(!isset(self::$_messages[$type][$key])) {
            return '';
        }

        return self::$_messages[$type][$key];
        */
        $type = (int) $error ? 1 : 0;
        $res = $this->_db->query("SELECT * FROM messages WHERE sessid = '" . $_COOKIE['PHPSESSID'] . "' AND error = $type AND mkey = '$key'");
        if($this->_db->num_rows($res)) {
            $fetch = $this->_db->fetch_array($res);
            $this->_db->query("DELETE FROM messages WHERE sessid = '" . $_COOKIE['PHPSESSID'] . "' AND error = $type AND mkey = '$key'");
            return $fetch['val'];
        }

        return '';
    }

    public function setMessage($key, $val, $error = false)
    {
        /*
        if($error) {
            self::$_messages['errors'][$key] = $val;
        } else {
            self::$_messages['messages'][$key] = $val;
        }
        */
        $type = (int) $error ? 1 : 0;
        $this->_db->query("INSERT INTO messages (mkey, val, error, sessid) VALUES ('" . $key . "', '" . $val . "', " . $type . ", '" . $_COOKIE['PHPSESSID'] . "')");
    }
    
    private function _getExceptionError($e)
    {
        return $e->getTraceAsString() . '<br />' . $e->getMessage() . '<br />';
    }
}

?>
