-- Database structure

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `rubric_id` int(11) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `master` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `enable_comments` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rubric_id` (`rubric_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
  
DROP TABLE IF EXISTS `news_comments`;

CREATE TABLE `news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(4096) NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT '0',
  `news_id` int(11) NOT NULL DEFAULT '0',
  `author_name` varchar(255) NOT NULL DEFAULT '',
  `author_ip` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `role` enum('admin', 'user') NOT NULL DEFAULT 'user',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `path` varchar(4096) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `adv`;

CREATE TABLE `adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advname` varchar(32) NOT NULL DEFAULT '',
  `advfile` varchar(512) NOT NULL DEFAULT '',
  `advurl` varchar(1024) NOT NULL DEFAULT '',
  `date_end` int(11) NOT NULL DEFAULT '0',
  `nuniq_show_count` int(11) NOT NULL DEFAULT '0',
  `nuniq_click_count` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `adv_uniq_show`;

CREATE TABLE `adv_uniq_show` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adv_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '127.0.0,1',
  PRIMARY KEY (`id`),
  KEY `adv_id` (`adv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `adv_uniq_click`;

CREATE TABLE `adv_uniq_click` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adv_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '127.0.0,1',
  PRIMARY KEY (`id`),
  KEY `adv_id` (`adv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `vcatalog`;

CREATE TABLE `vcatalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) NOT NULL DEFAULT '',
  `description` varchar(4096) NOT NULL DEFAULT '',
  `year` int(11) NOT NULL DEFAULT '0',
  `image` varchar(2048) NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT '0',
  `count_view` int(11) NOT NULL DEFAULT '0',
  `count_down` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `vcatalog_files`;

CREATE TABLE `vcatalog_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vcatalog_id` int(11) NOT NULL DEFAULT '0',
  `path` varchar(2048) NOT NULL DEFAULT '',
  `size` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `vcatalog_id` (`vcatalog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `vcatalog_janres`;

CREATE TABLE `vcatalog_janres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `janre` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `vcatalog_janre_ids`;

CREATE TABLE `vcatalog_janre_ids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vcatalog_janres_id` int(11) NOT NULL DEFAULT '0',
  `vcatalog_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `vcatalog_janres_id` (`vcatalog_janres_id`),
  KEY `vcatalog_id` (`vcatalog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `visitors_stat`;

CREATE TABLE `visitors_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `online_stat`;

CREATE TABLE `online_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0',
  `sessid` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
