<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$this->_tpl->db_stat = '<b>database statistics</b><br />time: ' . $this->_db->getWorkTime() .
    'ms, total queries: ' . $this->_db->getCountQuery() . '.';
?>
