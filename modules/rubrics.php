<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Controller_Rubrics implements Singleton {

    private static $_instance = null;

    private $_db, $_tpl, $_registry;
    
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
        $this->_tpl = Templater::getInstance();
    }

    public function index($params = null)
    {
        $main_news = null;
        $res = $this->_db->query("SELECT * FROM news WHERE deleted = 0 AND master = 1");
        if($this->_db->num_rows($res)) {
            $main_news = $this->_db->fetch_array($res);
            $body = $main_news['body'];
            if(mb_strlen($body) > 500) {
                $body = mb_substr($body, 0, 500);
                $body .= '...';
            }
            $main_news['body'] = $body;
            
            $main_news['image'] = array();

            $res = $this->_db->query("SELECT * FROM files WHERE news_id = " . $main_news['id'] . " ORDER BY id LIMIT 1");
            if($this->_db->num_rows($res)) {
                $main_news['image'] = $this->_db->fetch_array($res);
            }
        }
        $this->_tpl->main_news = $main_news;

        $rubrics = array();
        $res = $this->_db->query("SELECT * FROM rubrics WHERE deleted = 0 AND number > 0 ORDER BY number");
        if($this->_db->num_rows($res)) {
            while($fetch = $this->_db->fetch_array($res)) {
                $rubrics[] = $fetch;
            }
        }

        for($i = 0; $i < count($rubrics); $i++) {
            $res = $this->_db->query("SELECT * FROM news WHERE rubric_id = " . $rubrics[$i]['id'] .
                                     " AND deleted = 0 AND master = 0 ORDER BY id DESC LIMIT 1");
            if($this->_db->num_rows($res)) {
                $rubrics[$i]['top_news'] = $this->_db->fetch_array($res);
                
                $body = $rubrics[$i]['top_news']['body'];
                if(mb_strlen($body) > 200) {
                    $body = mb_substr($body, 0, 200);
                    $body .= '...';
                }
                $rubrics[$i]['top_news']['body'] = $body;
                
                $rubrics[$i]['top_news']['image'] = array();
                $res = $this->_db->query("SELECT * FROM files WHERE news_id = " . $rubrics[$i]['top_news']['id'] . " ORDER BY id LIMIT 1");
                if($this->_db->num_rows($res)) {
                    $rubrics[$i]['top_news']['image'] = $this->_db->fetch_array($res);
                }
            } else {
                $rubrics[$i]['top_news'] = null;
            }
        }
        
        $this->_tpl->rubrics = $rubrics;
        
        $this->_tpl->view();
        
        exit;
    }
}

?>
