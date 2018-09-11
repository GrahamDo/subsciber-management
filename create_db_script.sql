CREATE TABLE `subscriber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(320) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_address_UNIQUE` (`email_address`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 
	COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscriber_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `type` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `ix_subscriber_id_title` (`subscriber_id`,`title`),
  KEY `fk_subscriber_idx` (`subscriber_id`),
  CONSTRAINT `fk_subscriber` FOREIGN KEY (`subscriber_id`) 
	REFERENCES `subscriber` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
