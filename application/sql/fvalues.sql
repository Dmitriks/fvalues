CREATE TABLE IF NOT EXISTS `symbol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT IGNORE INTO `symbol` VALUES (1,'EURUSD','Euro vs US Dollar'),(2,'GBPUSD','Great Britain vs US Dollar'),(3,'USDJPY','US Dollar vs Japanese Yen'),(4,'USDCHF','US Dollar vs Swiss Franc'),(5,'GOLD','Gold'),(6,'SILVER','Silver'),(7,'#CL','Crude Oil Light Sweet'),(8,'#NG','Natural Gas');

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