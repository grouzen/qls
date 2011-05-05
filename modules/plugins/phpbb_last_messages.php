<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$current_date = date('Y-m-d', time());
$today = strtotime($current_date);

$phpbb_topics = array();

$this->_db->selectDB('phpbb3');

$res = $this->_db->query("SELECT * FROM phpbb_topics GROUP BY topic_last_post_time DESC LIMIT 10");
if($this->_db->num_rows($res)) {
    for($i = 0; $fetch = $this->_db->fetch_array($res); $i++) {
        $phpbb_topics[$i]['tid'] = $fetch['topic_id'];
        $phpbb_topics[$i]['fid'] = $fetch['forum_id'];
        $phpbb_topics[$i]['lpid'] = $fetch['topic_last_post_id'];
        $phpbb_topics[$i]['username'] = $fetch['topic_last_poster_name'];
        $phpbb_topics[$i]['title'] = $fetch['topic_title'];
        $phpbb_topics[$i]['today'] = $fetch['topic_last_post_time'] >= $today ? true : false;
    }
}

$this->_db->selectDB(Settings::getDbName());

$this->_tpl->phpbb_topics = $phpbb_topics;

?>
