<?php

//$tpl->usePlugin('forum_last_messages');
$tpl->usePlugin('phpbb_last_messages');
$tpl->usePlugin('adv');
$tpl->usePlugin('adv_190x300');
$tpl->usePlugin('adv_190x300a');
$tpl->usePlugin('adv_468x60bottom');
$tpl->usePlugin('adv_468x60top');
$tpl->usePlugin('adv_170x150');
$tpl->usePlugin('visitors_stat');
$tpl->usePlugin('messages_stat');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>Интернет провайдер "ЦИС Онлайн"</title>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="grouzen.hexy@gmail.com" />
    <meta name="keywords" content="провайдер, Алушта, интернет, онлайн, ЦИС Онлайн" />
    <meta name="description" content="Интернет провайдер ЦИС Онлайн, г. Алушта." />
    <link rel="icon" href="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme(); ?>/images/favicon0.png" type="image/png" />
    <script type="text/javascript">
      var addressSite = "<?php echo Settings::getAddressSite(); ?>";
      var currentTheme = "<?php echo Settings::getTheme(); ?>";
      var themesDir = "<?php echo THEMES; ?>";
    </script>
    <script type="text/javascript" src="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme(); ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme(); ?>/js/generic.js"></script>
    <link href="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme(); ?>/css/generic.css" type="text/css" rel="Stylesheet" />
  </head>
  <body>
    <div class="god-block">
      <div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td class="header-left">
              <div class="header-address">
                <a href="<?php echo Settings::getAddressSite(); ?>">cisonline.net.ua</a>
              </div>
            </td>
            <td class="header-center">
              <div class="header-name">
                ООО "ЦИС Онлайн"
              </div>
              <div class="header-motto">
                Весь мир в вашем компьютере!
              </div>
              <div class="header-info">
                Тел. техподдержки: (050) 8-400-130<br />
                Адрес офиса: г. Алушта, ул. В. Хромых 22, офис 4<br />
                E-mail: <a href="mailto:alushta.online@gmail.com">alushta.online@gmail.com</a>
              </div>
            </td>
            <td class="header-right">

            </td>
          </tr>
        </table>
      </div>
      <div class="whole-page">
        <div class="topmenu">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
              <td class="topmenu-left">
                
              </td>
              <td class="topmenu-center">
                <ul>
                  <li><a href="<?php echo Settings::getAddressSite(); ?>"><b>Главная</b></a></li>
                  <li><a href="<?php echo Settings::getAddressSite(); ?>about" target="_blank"><b>О нас</b></a></li>
                  <li><a href="<?php echo Settings::getAddressSite(); ?>services" target="_blank"><b>Услуги</b></a></li>
                  <li><a href="<?php echo Settings::getAddressSite(); ?>price" target="_blank"><b>Тарифы</b></a></li>
                  <li><a href="<?php echo Settings::getAddressSite(); ?>contract" target="_blank"><b>Договор</b></a></li>
                </ul>
              </td>
              <td class="topmenu-right">
                &nbsp;
              </td>
            </tr>
          </table>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td class="left-navi">
              <div class="left-navi-top">
                <ul class="left-navi-ul">
                  <li class="first"><a href="http://forum.<?php echo Settings::getDomainSite(); ?>/" target="_blank"><b>Форум</b></a></li>
                  <li><a href="ftp://media.zone/" target="_blank"><b>Файлообмен</b></a></li>
                  <li><a href="http://10.0.0.1/" target="_blank"><b>Статистика</b></a></li>
                  <li><a href="http://www.speedtest.net/?s=1008" target="_blank"><b>Тест скорости</b></a></li>
                  <li><a href="<?php echo Settings::getAddressSite(); ?>communication" target="_blank"><b>Общение</b></a></li>
                  <li><a href="http://10.0.0.1/soft/CISONLINE.exe" target="_blank"><b>Авторизатор</b></a></li>
                  <li><a href="http://video-network.zone/" target="_blank"><b>Каталог фильмов</b></a></li>
                  <li><a href="http://media.zone/" target="_blank"><b>Медиатека</b></a></li>
                </ul>
              </div>
              <div class="left-navi-bottom">
                &nbsp;
              </div>
              <div class="left-plugins">
                
                <?php include_once THEMES . Settings::getTheme() . '/plugins/phpbb_last_messages.tpl'; ?>
                
                <!--
                <div>
                  <h3>Популярное</h3>
                </div>
                <div>
                  &raquo <a href="">Саботаж</a><br />
                  &raquo <a href="">Who cares?</a><br />
                </div>
                -->
                <?php include_once THEMES . Settings::getTheme() . '/plugins/adv_170x150.tpl'; ?>
                <!--
                <div>
                  <h3>Реклама</h3>
                  <img src="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme() . '/images/banner3.jpg'; ?>" />
                </div>
                -->
                <div>
                  <!--
                  <h3>Статистика сообщений</h3>
                  <ul class="left-plugins-stat-ul">
                    <li class="first">Материалов на сайте</li>
                    <li>Комментариев на сайте</li>
                    <li>Пользователей</li>
                  </ul>
                  -->
                  <?php include_once THEMES . Settings::getTheme() . '/plugins/messages-stat.tpl'; ?>
                </div>
                <div class="left-plugins-footage">
                  &nbsp;
                </div>
                <div class="left-plugins-friends">
                  <div>
                    <h3>Сайты друзей</h3>
                  </div>
                  <ul class="left-plugins-friends-ul">
                    <li class="first"><a href="http://alushtalive.com/">alushtalive.com</a></li>
                    <!--<li><a href="http://alushta.net/">alushta.net</a></li>-->
                    <li><a href="http://network.zone/">network.zone</a></li>
                    <li><a href="http://elitokno.cisonline.net.ua/">elitokno.cisonline.net.ua</a></li>
                  </ul>
                </div>
              </div>
            </td>
            <td>
              <div class="center-whole-page">
                <div class="center-inner-page">
                  <?php include_once THEMES . Settings::getTheme() . '/plugins/adv_468x60top.tpl'; ?>
                  <!--<script type="text/javascript" src="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme(); ?>/js/newyear.js"></script>-->
                  <!--
                  <div class="center-banner-top">
                    <img src="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme() . '/images/banner.jpg'; ?>" />
                    
                    <embed src="http://fotoart.tv/admin/fotoart.swf" quality="high" scale="noscale" bgcolor="#fff" width="468" height="60" name="main" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_ru" />
                  </div>
                  -->
                  <div class="center-banner-line">
                    &nbsp;
                  </div>
