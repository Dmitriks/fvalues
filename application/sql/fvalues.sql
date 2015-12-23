CREATE TABLE IF NOT EXISTS `symbol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `visible` boolean NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT IGNORE INTO `symbol` VALUES (1,'EURUSD','Euro vs US Dollar',1,1),(2,'GBPUSD','Great Britain Pound vs US Dollar',1,2),(3,'USDJPY','US Dollar vs Japanese Yen',1,3),(4,'USDCHF','US Dollar vs Swiss Franc',1,4),(7,'USDCNY','US Dollar vs Chinese yuan',0,7),(8,'USDRUR','US Dollar vs Russian ruble',0,8),(9,'USDUAH','US Dollar vs Ukrainian hryvnia',0,9),(10,'GOLD','Gold',1,10),(11,'SILVER','Silver',1,11),(12,'#CL','Crude Oil Light Sweet',1,12);

CREATE TABLE IF NOT EXISTS `minute_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `symbol_id` int(11) NOT NULL DEFAULT '0',
  `bid` DECIMAL(11,4),
  `ask` DECIMAL(11,4),
  `time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `symbol_id` (`symbol_id`, `time`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `hour_value` LIKE `minute_value`;

CREATE TABLE IF NOT EXISTS `day_value` LIKE `hour_value`;

CREATE TABLE IF NOT EXISTS `month_value` LIKE `day_value`;