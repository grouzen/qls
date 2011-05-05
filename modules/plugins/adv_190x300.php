<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$adv = $this->_tpl->controller_adv->show('190x300');
if(!is_null($adv)) {
    $this->_tpl->adv_190x300 = $adv;
} else {
    $this->_tpl->adv_190x300 = array('id' => '0',
                                     'file' => 'ee83069c28cf3af33003add2ce05d1ce.png');
}

?>
