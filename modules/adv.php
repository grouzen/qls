<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Controller_Adv implements Singleton {

    private static $_instance = null;

    private $_db;
    private $_registry;
    
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
        $this->_registry = Registry::getInstance();
    }
    
    public function show($advname)
    {
        $advname = trim($this->_db->escapeString($advname));
        $date_cur = time();
        $res_adv = $this->_db->query("SELECT * FROM adv WHERE deleted = 0 AND advname = '" . $advname . "' AND date_end > " . $date_cur);
        if($this->_db->num_rows($res_adv)) {
            $fetch_adv = $this->_db->fetch_array($res_adv);
            $ip = $this->_registry->get('remote_addr');

            if($fetch_adv['date_end'] < $date_cur)
                return null;

            $this->_db->query("UPDATE adv SET nuniq_show_count = nuniq_show_count + 1 WHERE id = " . $fetch_adv['id']);

            $assert_adv_uniq_show = $this->_db->query("SELECT * FROM adv_uniq_show WHERE adv_id = " . $fetch_adv['id'] . " AND ip = '" . $ip . "'");
            if(!$this->_db->num_rows($assert_adv_uniq_show)) {
                $this->_db->query("INSERT INTO adv_uniq_show (adv_id, ip) VALUES (" . $fetch_adv['id'] . ", '" . $ip . "')");
            }

            return array('id' => $fetch_adv['id'], 'file' => $fetch_adv['advfile']);
        }

        return null;
    }

    public function click($params = null)
    {
        $advid = (int) $params[0];
        $ip = $this->_registry->get('remote_addr');
        
        $assert = $this->_db->query("SELECT * FROM adv WHERE deleted = 0 AND id = $advid");
        if(!$this->_db->num_rows($assert)) {
            Router::getInstance()->redirect(Settings::getAddressSite());
            exit;
        }
        $fetch = $this->_db->fetch_array($assert);
        
        $this->_db->query("UPDATE adv SET nuniq_click_count = nuniq_click_count + 1 WHERE id = $advid");

        $assert_adv_uniq_click = $this->_db->query("SELECT * FROM adv_uniq_click WHERE adv_id = $advid AND ip = '" . $ip . "'");
        if(!$this->_db->num_rows($assert_adv_uniq_click)) {
            $this->_db->query("INSERT INTO adv_uniq_click (adv_id, ip) VALUES ($advid, '" . $ip . "')");
        }

        Router::getInstance()->redirect($fetch['advurl']);

        exit;
    }

    public function generateTag($adv, $w, $h)
    {
        $tag = '';
 
        $suffix = substr(strrchr($adv['file'], '.'), 1);
        
        switch($suffix) {
        case 'x-shockwave-flash':
            $tag = '<embed src="' . Settings::getAddressSite() . FILES . 'adv/' . $adv['file'] . '" quality="high" scale="scale" bgcolor="#fff" width="' . $w . '" height="' . $h . '" name="main" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_ru" />';
            break;
        default: /* Images. */
            $tag = '<a href="' . Settings::getAddressSite() . 'adv/click/' . $adv['id'] . '" target="_blank"><img width="' . $w . '" height="' . $h . '" src="' . Settings::getAddressSite() . 'files/adv/' . $adv['file'] . '" /></a>';
            break;
        }

        return $tag;
    }
}
    
?>
