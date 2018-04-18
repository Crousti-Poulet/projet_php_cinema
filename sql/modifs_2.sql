ALTER TABLE `movies` ADD `length` SMALLINT NOT NULL AFTER `title`;
ALTER TABLE `movies` CHANGE `length` `length` SMALLINT(6) NOT NULL COMMENT 'en minutes';
ALTER TABLE `movies` ADD `actors` VARCHAR(255) NULL AFTER `director`;
ALTER TABLE `movies` ADD `genre` VARCHAR(255) NOT NULL AFTER `date_release`, ADD `country` VARCHAR(255) NOT NULL AFTER `genre`;
ALTER TABLE `users` CHANGE `email` `email` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'unique, sert de login';