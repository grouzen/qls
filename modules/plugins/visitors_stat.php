<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$year = date('Y', time());
$month = date('m', time());
$day = date('d', time());

$today_start = strtotime("$year-$month-$day");
$today_end = $today_start + 86400;

$res_visitors_stat_today = $this->_db->query("SELECT * FROM visitors_stat WHERE date >= $today_start AND date < $today_end");
$this->_tpl->today_count = $this->_db->num_rows($res_visitors_stat_today);

$yesterday_start = $today_start - 86400;
$res_visitors_stat_yesterday = $this->_db->query("SELECT * FROM visitors_stat WHERE date >= $yesterday_start AND date < $today_start");
$this->_tpl->yesterday_count = $this->_db->num_rows($res_visitors_stat_yesterday);

$onthisweek_start = $today_end - (86400 * 7);
$res_visitors_stat_onthisweek = $this->_db->query("SELECT * FROM visitors_stat WHERE date >= $onthisweek_start AND date < $today_end");
$this->_tpl->onthisweek_count = $this->_db->num_rows($res_visitors_stat_onthisweek);

$onthismonth_start = $today_end - (86400 * 30);
$res_visitors_stat_onthismonth = $this->_db->query("SELECT * FROM visitors_stat WHERE date >= $onthismonth_start AND date < $today_end");
$this->_tpl->onthismonth_count = $this->_db->num_rows($res_visitors_stat_onthismonth);

$res_visitors_stat_entire = $this->_db->query("SELECT * FROM visitors_stat");
$this->_tpl->entire_count = $this->_db->num_rows($res_visitors_stat_entire);

$res_online_stat = $this->_db->query("SELECT * FROM online_stat");
$this->_tpl->online_count = $this->_db->num_rows($res_online_stat);

$this->_tpl->your_ip = $this->_registry->get('remote_addr');

?>