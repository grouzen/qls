<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$day_start = date('Y-m-d', time());
$time_start = strtotime($day_start);

$res_news_entire = $this->_db->query("SELECT * FROM news WHERE deleted = 0");
$this->_tpl->news_entire_count = $this->_db->num_rows($res_news_entire);

$res_news_comments_entire = $this->_db->query("SELECT * FROM news_comments WHERE deleted = 0");
$this->_tpl->news_comments_entire_count = $this->_db->num_rows($res_news_comments_entire);

$res_news_new = $this->_db->query("SELECT * FROM news WHERE deleted = 0 AND date > $time_start");
$this->_tpl->news_new_count = $this->_db->num_rows($res_news_new);

$res_news_comments_new = $this->_db->query("SELECT * FROM news_comments WHERE deleted = 0 AND date > $time_start");
$this->_tpl->news_comments_new_count = $this->_db->num_rows($res_news_comments_new);

?>
