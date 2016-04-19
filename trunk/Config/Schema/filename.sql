

DROP TABLE IF EXISTS `mytest`.`categories`;
DROP TABLE IF EXISTS `mytest`.`groups`;
DROP TABLE IF EXISTS `mytest`.`posts`;
DROP TABLE IF EXISTS `mytest`.`users`;


CREATE TABLE `mytest`.`categories` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `mytest`.`groups` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `mytest`.`posts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`body` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `mytest`.`users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`password` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`group_id` int(11) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `username` (`username`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

