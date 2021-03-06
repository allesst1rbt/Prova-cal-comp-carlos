CREATE TABLE `DQC841` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FART_PART_NO` int(11) NOT NULL,
  `PARTS_NO` varchar(15) NOT NULL,
  `UNT_USG` int(11) NOT NULL,
  `DESCRIPTION` longtext NOT NULL,
  `REF_DESIGNATOR` longtext DEFAULT NULL,
  `UPDATE_DT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREATE_DT` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UQ_PARTS` (`FART_PART_NO`,`PARTS_NO`),
  KEY `fk_DQC841_1_idx` (`FART_PART_NO`),
  CONSTRAINT `fk_DQC841_1` FOREIGN KEY (`FART_PART_NO`) REFERENCES `DQC84` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4