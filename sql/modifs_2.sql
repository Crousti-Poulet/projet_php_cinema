ALTER TABLE `movies` ADD `length` SMALLINT NOT NULL AFTER `title`;
ALTER TABLE `movies` CHANGE `length` `length` SMALLINT(6) NOT NULL COMMENT 'en minutes';