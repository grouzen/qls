<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

error_reporting(E_ALL);
mb_internal_encoding('UTF-8');

define('QLS', 1);
//define('DOCROOT', '/var/virtuals/aol.net.ua/newportal/');
define('SYSTEMS', 'system/');
define('MODULES', 'modules/');
define('MODULES_PLUGINS', MODULES . '/plugins/');
define('THEMES', 'themes/');
define('FILES', 'files/');
define('LIBS', 'libs/');

/* Directory for store files of sessions. */
ini_set('session.save_path', 'sessions');

function __autoload($classname)
{
    include_once  SYSTEMS . strtolower($classname) . '.php';
}

DB::getInstance()->connect();
Messages::getInstance(); /* It prevent some errors. */
Sessions::getInstance()->start();
Router::getInstance()->process();

?>
