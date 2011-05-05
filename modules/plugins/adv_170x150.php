<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$adv = $this->_tpl->controller_adv->show('170x150');
if(!is_null($adv)) {
    $this->_tpl->adv_170x150 = $adv;
} else {
    $this->_tpl->adv_170x150 = array('id' => '0',
                                     'file' => 'afeb0f15cac1ba2280e0408abef00a06.jpeg');
}

?>
