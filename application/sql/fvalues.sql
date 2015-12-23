CREATE TABLE IF NOT EXISTS `symbol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `visible` boolean NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT IGNORE INTO `symbol` VALUES (1,'EURUSD','Euro vs US Dollar',1,1),(2,'GBPUSD','Great Britain Pound vs US Dollar',1,2),(3,'USDJPY','US Dollar vs Japanese Yen',1,3),(4,'USDCHF','US Dollar vs Swiss Franc',1,4),(5,'USDCAD','US Dollar vs Canadian',0,5),(6,'AUDUSD','Australian vs US Dollar',0,6),(7,'GOLD','Gold',1,7),(8,'SILVER','Silver',1,8),(9,'#CL','Crude Oil Light Sweet',1,9),(10,'#NG','Natural Gas',0,10),(11,'USDUAH','US Dollar vs Ukrainian hryvnia',0,11),(12,'USDRUR','US Dollar vs Russian ruble',0,12);

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