<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Mysql implements Singleton {

    private static $_instance = null;

    private static $_count_query = 0;
    private static $_work_time = 0;

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    public function connect()
    {
        $stime = microtime(1);
        
        try {
            if(!mysql_connect(Settings::getDbHost(),
                              Settings::getDbUser(),
                              Settings::getDbPassword())) {
                throw new Exception("Wrong parameters of connection to DB");
            }

            $this->selectDB(Settings::getDbName());
            
            $this->query("SET NAMES 'utf8'");
        } catch(Exception $e) {
            echo $this->_getExceptionError($e);
        }

        self::$_work_time += microtime(1) - $stime;
    }

    public function selectDB($name)
    {
        try {
            if(!mysql_select_db($name)) {
                throw new Exception("Wrong DB name");
            }
        } catch(Exception $e) {
            echo $this->_getExceptionError($e);
        }
    }
    
    public function escapeString($string)
    {
        return mysql_real_escape_string($string);
    }
    
    public function query($query)
    {
        $stime = microtime(1);
        
        try {
            if(($result = mysql_query($query)) != false) {
                self::$_count_query++;
                self::$_work_time += microtime(1) - $stime;
                return $result;
            } else {
                throw new Exception("Incorrect syntax of query to DB: " . mysql_error());
            }
        } catch(Exception $e) {
            echo $this->_getExceptionError($e);
        }
    }

    public function fetch_array($result)
    {
        $stime = microtime(1);
        $fetch_array = mysql_fetch_array($result);
        self::$_work_time += microtime(1) - $stime;
        return $fetch_array;
    }

    public function num_rows($result)
    {
        $stime = microtime(1);
        $num_rows = mysql_num_rows($result);
        self::$_work_time += microtime(1) - $stime;
        return $num_rows;
    }
    
    /* Return time spent for work with DB in milliseconds. */
    public static function getWorkTime()
    {
        return substr(self::$_work_time * 1000, 0, 6);
    }

    /* Return count of queries to DB. */
    public static function getCountQuery()
    {
        return self::$_count_query;
    }
    
    private function _getExceptionError($e)
    {
        return $e->getTraceAsString() . '<br />' . $e->getMessage() . '<br />';
    }
}

?>
