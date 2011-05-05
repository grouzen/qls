<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$adv = $this->_tpl->controller_adv->show('468x60bottom');
if(!is_null($adv)) {
    $this->_tpl->adv_468x60bottom = $adv;
} else {
    $this->_tpl->adv_468x60bottom = array('id' => '0',
                                          'file' => '67787d83002099c345f50695a0aa8d99.png');
}

?>
