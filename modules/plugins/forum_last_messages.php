<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$current_date = date('Y-m-d', time());
$today = strtotime($current_date);

$topics = array();

$this->_db->selectDB('forum');

$res = $this->_db->query("SELECT * FROM ipb_topics GROUP BY last_post DESC LIMIT 10");

if($this->_db->num_rows($res)) {
    for($i = 0; $fetch = $this->_db->fetch_array($res); $i++) {
        $topics[$i]['id'] = $fetch['tid'];
        $topics[$i]['today'] = $fetch['last_post'] >= $today ? true : false;
        $topics[$i]['title'] = $fetch['title'];
        $topics[$i]['name'] = $fetch['last_poster_name'];
    }
}

$this->_db->selectDB(Settings::getDbName());

$this->_tpl->topics = $topics;

?>