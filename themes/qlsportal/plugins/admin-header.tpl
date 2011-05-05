<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
  <head>
    <title><?php echo Settings::getDomainSite(); ?> - Администрирование сайта.</title>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme(); ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme(); ?>/js/admin.js"></script>
    <script type="text/javascript" src="<?php echo Settings::getAddressSite(); ?>libs/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript">
      tinyMCE.init({
      mode: "textareas",
      language: "ru",
      convert_urls: false,
      theme: "advanced",
      //theme_advanced_disable: "unlink,anchor,cleanup,help,code,sub,sup,separator,outdent,indent,charmap,visualaid,cut",
      theme_advanced_buttons1: "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,numlist,bullist,undo,redo,link,image,fontselect,fontsizeselect,formatselect,forecolor",
      theme_advanced_buttons2: "",
      theme_advanced_buttons3: "",
      theme_advanced_toolbar_location: "top"
      });
    </script>
    <link href="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme() . '/css/admin.css'; ?>" type="text/css" rel="Stylesheet" />
  </head>
  <body>
    <center>
      <b>Вы вошли как: <font color="#ee9201"><?php echo $_SESSION['login']; ?>, <?php echo $_SESSION['role']; ?></font></b>
      <?php if($_SESSION['role'] !== 'guest') { ?>
      <br />
      <a href="<?php echo Settings::getAddressSite(); ?>admin/logout/">Выйти</a>
      <?php } ?>
    </center>
    <table align="center" height="800" width="800" cellspacing="0" border="0">
      <tr>
        <td valign="top">
          <table width="100" border="0">
            <tr>
              <td align="left">
                <?php if($_SESSION['role'] === 'admin') { ?>
                <a href="<?php echo Settings::getAddressSite(); ?>admin/admins/">Администраторы</a> <br />
                <a href="<?php echo Settings::getAddressSite(); ?>admin/news/">Нововсти</a> <br />
                <?php } ?>
                <?php if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user') { ?>
                <a href="<?php echo Settings::getAddressSite(); ?>admin/adv/">Реклама</a> <br />
                <?php } ?>
              </td>
            </tr>
          </table>
        </td>
        <td valign="top">
          <table width="700" cellspacing="0" cellpadding="0" border="0">
            
