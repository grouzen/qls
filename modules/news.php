<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Controller_News implements Singleton {

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
        $per_page = 10;
        $page = 1;
        if($params[0] === 'page') {
            $page = (int) $params[1];
            if($page < 1) {
                Router::getInstance()->redirect(Settings::getError404());
                exit;
            }
        }
        $page--;
        $this->_tpl->per_page = $per_page;
        $this->_tpl->page = $page;

        $res = $this->_db->query("SELECT COUNT(*) AS news_count FROM news WHERE deleted = 0");
        $fetch = $this->_db->fetch_array($res);
        $this->_tpl->news_count = $fetch['news_count'];

        
        $news = array();
        $res = $this->_db->query("SELECT * FROM news WHERE deleted = 0 ORDER BY id DESC LIMIT " . ($page * $per_page) . ", " . $per_page);
        if($this->_db->num_rows($res)) {
            for($i = 0; $fetch = $this->_db->fetch_array($res); $i++) {
                $news[$i] = $fetch;
                // replace "\r\n" with "<br />"
                $body = $news[$i]['body'];
                //$body = preg_replace("/\r\n/", '<br />', $body);
                $news[$i]['body'] = $body;

                $res_users = $this->_db->query("SELECT * FROM users WHERE id = " . $fetch['author_id']);
                if($this->_db->num_rows($res_users)) {
                    $fetch_users = $this->_db->fetch_array($res_users);
                    $news[$i]['author_name'] = $fetch_users['name'];
                } else {
                    $news[$i]['author_name'] = 'Неизвестен';
                }

                $res_comments = $this->_db->query("SELECT COUNT(*) AS comments_count FROM news_comments WHERE deleted = 0 AND news_id = " . $fetch['id']);
                $fetch_comments = $this->_db->fetch_array($res_comments);
                $news[$i]['comments_count'] = $fetch_comments['comments_count'];
            }
        }
        $this->_tpl->news = $news;
        
        $images = array();
        $res = $this->_db->query("SELECT * FROM files");
        if($this->_db->num_rows($res)) {
            while($fetch = $this->_db->fetch_array($res)) {
                $images[] = $fetch;
            }
        }
        $this->_tpl->images = $images;

        $this->_tpl->view();

        exit;
    }

    public function more($params = null)
    {
        $id = (int) $params[0];

        $news = array();
        $res = $this->_db->query("SELECT * FROM news WHERE deleted = 0 AND id = $id");
        if($this->_db->num_rows($res)) {
            $news = $this->_db->fetch_array($res);
            // replace "\r\n" with "<br />"
            $news['body'] = preg_replace("/\r\n/", '<br />', $news['body']);
            
            $res_users = $this->_db->query("SELECT * FROM users WHERE id = " . $news['author_id']);
            if($this->_db->num_rows($res_users)) {
                $fetch_users = $this->_db->fetch_array($res_users);
                $news['author_name'] = $fetch_users['name'];
            } else {
                $news['author_name'] = 'Неизвестен';
            }
            
            $news['comments'] = array();
            $res_comments = $this->_db->query("SELECT * FROM news_comments WHERE deleted = 0 AND news_id = $id");
            if($this->_db->num_rows($res_comments)) {
                for($i = 0; $fetch = $this->_db->fetch_array($res_comments); $i++) {
                    $news['comments'][$i] = $fetch;
                    $news['comments'][$i]['order'] = $i + 1;
                    $news['comments'][$i]['text'] = preg_replace("/\r\n/", '<br />', $news['comments'][$i]['text']);
                }
            }
        }
        $this->_tpl->news = $news;

        $this->_tpl->view();
        
        exit;
    }

    public function deletecomment($params = null)
    {
        $news_id = (int) $params[0];
        $comment_id = (int) $params[1];

        if($_SESSION['role'] === 'admin') {
            //$this->_db->query("DELETE FROM news_comments WHERE id = $comment_id");
            $this->_db->query("UPDATE news_comments SET deleted = 1 WHERE id = $comment_id");
            new SetMessage('news-deletecomment-message', 'Комментарий успешно удален');
        } else {
            new SetError('news-deletecomment-error', 'У вас недостаточно прав');
        }

        //Router::getInstance()->delegate('news', 'more', array($news_id));
        Router::getInstance()->redirect(Settings::getAddressSite() . 'news/more/' . $news_id);
        exit;
    }
    
    public function addcomment($params = null)
    {
        $id = (int) $params[0];
        $author_name = htmlspecialchars($this->_db->escapeString($_POST['author_name']));
        $text = $_POST['text'];
        $text = htmlspecialchars($text);
        //$text = preg_replace("/\r\n/", '<br>', $text);
        $text = $this->_db->escapeString($text);
        
        
        $assert = $this->_db->query("SELECT * FROM news WHERE id = " . $id . " AND deleted = 0");
        if(!$this->_db->num_rows($assert)) {
            Router::getInstance()->redirect(Settings::getError404());
        }

        if(empty($author_name) || empty($text)) {
            new SetError('news-addcomment-error', 'Одно из обязательных полей не заполнено');
        } else {
            //new SetError('news-addcomment-error', 'Ошибка базы данных');
            
            $this->_db->query("INSERT INTO news_comments (text, date, news_id, author_name, author_ip) VALUES ('" .
                              $text . "', " . time() . ", " . $id . ", '" . $author_name . "', '" . $this->_registry->get('remote_addr') . "')");
            new SetMessage('news-addcomment-message', 'Ваш комментарий успешно добавлен');
            
        }
        
        //Router::getInstance()->delegate('news', 'more', array($id));
        Router::getInstance()->redirect(Settings::getAddressSite() . 'news/more/' . $id);
        exit;
    }
}

?>
