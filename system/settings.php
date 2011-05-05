<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Settings {

    private static $_start_time = null;
    private static $_cookie_expire = 259200;
    
    /* DB. */
    private static $_db_type = 'mysql';
    private static $_db_host = 'localhost';
    private static $_db_name = 'qlsportal';
    private static $_db_user = 'root';
    private static $_db_password = 'be7196904c4ae126';

    /* Routing. */
    private static $_domain_site = 'cisonline.net.ua';
    private static $_address_site = 'http://cisonline.net.ua/';
    private static $_default_module = 'news';
    private static $_default_action = 'index';
    private static $_error_404 = '404.html';

    /* Themes. */
    private static $_theme = 'qlsportal';

    /* Mail. */
    private static $_mail_backend = 'smtp';
    private static $_mail_host = 'gmail.com';
    private static $_mail_port = 25;
    private static $_mail_auth = true;
    private static $_mail_username = 'gro19u89zen';
    private static $_mail_password = 'c013a727f4';
    private static $_mail_from = 'Support <gro19u89zen@gmail.com>';
    private static $_mail_subject = 'Successful registering.';

    public static function getMailSubject()
    {
        return self::$_mail_subject;
    }
    
    public static function getMailFrom()
    {
        return self::$_mail_from;
    }
    
    public static function getMailBackend()
    {
        return self::$_mail_backend;
    }

    public function getMailHost()
    {
        return self::$_mail_host;
    }

    public function getMailPort()
    {
        return self::$_mail_port;
    }

    public function getMailAuth()
    {
        return self::$_mail_auth;
    }

    public function getMailUsername()
    {
        return self::$_mail_username;
    }

    public function getMailPassword()
    {
        return self::$_mail_password;
    }
    
    public static function getDbType()
    {
        return self::$_db_type;
    }

    public static function getDbHost()
    {
        return self::$_db_host;
    }
    
    public static function getDbName()
    {
        return self::$_db_name;
    }
    
    public static function getDbUser()
    {
        return self::$_db_user;
    }
    
    public static function getDbPassword()
    {
        return self::$_db_password;
    }

    public static function getDomainSite()
    {
        return self::$_domain_site;
    }
    
    public static function getAddressSite()
    {
        return self::$_address_site;
    }

    public static function getDefaultModule()
    {
        return self::$_default_module;
    }
    
    public static function getDefaultAction()
    {
        return self::$_default_action;
    }
    
    public static function getError404()
    {
        return self::$_address_site . self::$_error_404;
    }

    public static function getCookieExpire()
    {
        return self::$_cookie_expire;
    }

    public static function getTheme()
    {
        return self::$_theme;
    }


    public static function getTime($new)
    {
        if($new) {
            self::$_start_time = microtime(1);
        } else {
            return substr((microtime(1) - self::$_start_time) * 1000, 0, 4);
        }
    }
}

?>
