<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Controller_Rss implements Singleton {

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
        /*
        include_once LIBS . 'FeedWriter/FeedWriter.php';

        $rss2 = new FeedWriter(RSS2);

        $rss2->setTitle('RSS');
        $rss2->setLink(Settings::getAddressSite() . 'rss');
        $rss2->setDescription('Новостная лента провайдера ООО "ЦИС Онлайн", Алушта');
        //$rss2->setImage('RSS', Settings::getAddressSite() . MODULES_PLUGINS . 'rss.php', Settings::getAddressSite() . THEMES . Settings::getTheme() . '/images/favicon0.png');

        $rss2->setChannelElement('language', 'ru');
        $rss2->setChannelElement('pubDate', date(DATE_RSS, time()));

        $rss2_res = $this->_db->query("SELECT * FROM news WHERE deleted = 0 ORDER BY id DESC LIMIT 0, 10");
        if($this->_db->num_rows($rss2_res)) {
            while($rss2_fetch = $this->_db->fetch_array($rss2_res)) {
                $item = $rss2->createNewItem();
        
                $item->setTitle($rss2_fetch['title']);
                $item->setLink(Settings::getAddressSite() . 'news/more/' . $rss2_fetch['id']);
                $item->setDate($rss2_fetch['date']);
                $item->setDescription($rss2_fetch['body']);

                $rss2->addItem($item);
            }
        }
        
        $rss2->genarateFeed();
        */

        include_once LIBS . 'feedcreator/include/feedcreator.class.php';

        $rss = new UniversalFeedCreator();
        $rss->useCached();
        $rss->title = 'Cisonline.net.ua: Новости';
        $rss->description = 'Последние 10 новостей';
        $rss->link = Settings::getAddressSite();
        $rss->language = 'ru';
        $rss->syndicationURL = Settings::getAddressSite() . 'rss';
        
        $rss_res = $this->_db->query("SELECT * FROM news WHERE deleted = 0 ORDER BY id DESC LIMIT 0, 10");
        if($this->_db->num_rows($rss_res)) {
            while($rss_fetch = $this->_db->fetch_array($rss_res)) {
                $item = new FeedItem();
        
                $item->title = $rss_fetch['title'];
                $item->link = Settings::getAddressSite() . 'news/more/' . $rss_fetch['id'];
                $item->date = $rss_fetch['date'];
                $item->description = $rss_fetch['body'];

                $rss->addItem($item);
            }
        }

        $rss->outputFeed("RSS2.0");

    }
}

?>
