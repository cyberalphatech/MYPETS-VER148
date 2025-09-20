-- Create vaccines table for storing vaccine information
CREATE TABLE IF NOT EXISTS `tblmypets_vaccines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vaccine_name` varchar(255) NOT NULL,
  `animal_type` varchar(100) NOT NULL,
  `vaccine_type` enum('Core','Non-Core','Lifestyle') NOT NULL DEFAULT 'Core',
  `description` text,
  `frequency` varchar(100),
  `age_range` varchar(100),
  `manufacturer` varchar(255),
  `dosage` varchar(100),
  `route` varchar(50),
  `notes` text,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `animal_type` (`animal_type`),
  KEY `vaccine_type` (`vaccine_type`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
