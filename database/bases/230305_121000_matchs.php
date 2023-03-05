<?php

return
    'CREATE TABLE `t_match` (
      `mac_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `mac_id_wpo` int(11) DEFAULT NULL,
      `mac_numb` int(11) NOT NULL,
      `mac_coupe` tinyint(1) NOT NULL DEFAULT 0,
      `mac_date` datetime NOT NULL,
      `mac_id_piscine` int(11) DEFAULT NULL,
      `mac_club_in` varchar(255) NOT NULL,
      `mac_initiale_in` varchar(10) NOT NULL,
      `mac_club_out` varchar(255) NOT NULL,
      `mac_initiale_out` varchar(10) NOT NULL,
      `mac_score` varchar(255) DEFAULT NULL,
      `mac_arbitre` varchar(255) DEFAULT NULL,
      `mac_id_saison` int(11) NOT NULL,
      `mac_id_categorie` int(11) NOT NULL,
      `mac_date_modif` date DEFAULT NULL,
      `mac_supp` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
