<?php

if(!defined('QLS'))
	die("Is thou hacker?! NO WAY!");

$adv = $this->_tpl->controller_adv->show('190x300a');
if(!is_null($adv)) {
    $this->_tpl->adv_190x300a = $adv;
} else {
    $this->_tpl->adv_190x300a = array('id' => '0',
                                     'file' => '91bae6ee7e9618159a121e3614fa5e73.png');
}

?>
