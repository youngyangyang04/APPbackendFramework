# Host: 120.24.226.68  (Version: 5.1.73-log)
# Date: 2016-06-02 16:19:01
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ads"
#

DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `pic_name` varchar(255) DEFAULT NULL,
  `pic_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Structure for table "check_msg"
#

DROP TABLE IF EXISTS `check_msg`;
CREATE TABLE `check_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '短信id',
  `phone` bigint(11) NOT NULL COMMENT '注册手机',
  `phone_code` varchar(100) NOT NULL COMMENT '验证码',
  `curr_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aftaer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

#
# Structure for table "comment"
#

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `shuoshuoID` int(11) NOT NULL DEFAULT '0',
  `uID` varchar(255) NOT NULL DEFAULT '',
  `content` varchar(255) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Structure for table "feedback"
#

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) DEFAULT NULL,
  `phone` int(11) NOT NULL DEFAULT '0',
  `feedback` varchar(1000) DEFAULT NULL,
  `feedback_pic` varchar(255) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

#
# Structure for table "friends"
#

DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uID` int(11) NOT NULL,
  `friendID` int(11) DEFAULT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Structure for table "friendslike"
#

DROP TABLE IF EXISTS `friendslike`;
CREATE TABLE `friendslike` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `shuoshuoID` int(11) NOT NULL DEFAULT '0',
  `likeID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Structure for table "game_gift"
#

DROP TABLE IF EXISTS `game_gift`;
CREATE TABLE `game_gift` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `pic_name` varchar(255) DEFAULT NULL,
  `pic_detail_name` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Structure for table "game_rule"
#

DROP TABLE IF EXISTS `game_rule`;
CREATE TABLE `game_rule` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Structure for table "news"
#

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `pic_url` varchar(255) DEFAULT NULL,
  `uptime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Structure for table "pictures"
#

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE `pictures` (
  `picID` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `shuoshuoID` varchar(255) NOT NULL DEFAULT '',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`picID`)
) ENGINE=MyISAM AUTO_INCREMENT=2361 DEFAULT CHARSET=utf8;

#
# Structure for table "robot"
#

DROP TABLE IF EXISTS `robot`;
CREATE TABLE `robot` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `rID` int(11) NOT NULL DEFAULT '0',
  `robotname` varchar(255) DEFAULT NULL,
  `portrait` varchar(255) DEFAULT NULL,
  `QRcode` varchar(255) DEFAULT NULL,
  `shuoshuoCount` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Structure for table "shuoshuo"
#

DROP TABLE IF EXISTS `shuoshuo`;
CREATE TABLE `shuoshuo` (
  `shuoshuoID` int(11) NOT NULL AUTO_INCREMENT,
  `rID` int(11) NOT NULL DEFAULT '0',
  `content` varchar(1000) DEFAULT '',
  `commentNum` int(11) DEFAULT NULL,
  `zanNum` int(11) NOT NULL DEFAULT '0',
  `picsURL` varchar(1000) NOT NULL DEFAULT '',
  `thumbsURL` varchar(255) NOT NULL,
  `picsID` varchar(1000) NOT NULL DEFAULT '',
  `zanyourself` int(11) DEFAULT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`shuoshuoID`)
) ENGINE=MyISAM AUTO_INCREMENT=1925 DEFAULT CHARSET=utf8;

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT NULL,
  `sign` varchar(255) DEFAULT NULL,
  `portrait` varchar(255) DEFAULT NULL,
  `phone` bigint(11) NOT NULL DEFAULT '0',
  `shuoshuoCount` int(11) DEFAULT NULL,
  `friendsCount` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `QRcode` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL DEFAULT '',
  `area` varchar(255) NOT NULL DEFAULT '',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bbirthday` varchar(255) DEFAULT NULL COMMENT '宝贝生日',
  `salary` float(2,0) DEFAULT NULL COMMENT '年收入',
  `work_certificate` varchar(255) DEFAULT NULL COMMENT '工作证',
  `score` int(11) NOT NULL DEFAULT '0',
  `num_invite` int(11) NOT NULL DEFAULT '0' COMMENT '邀请其他人的数量',
  `sign_in_time` timestamp NOT NULL DEFAULT '2000-01-01 00:00:00',
  `continuous_days` int(11) DEFAULT NULL,
  `game_score` int(11) NOT NULL DEFAULT '0',
  `country` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uID`),
  KEY `phone` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
