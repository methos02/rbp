<?php

return
    'CREATE TABLE `t_adherent_saison` (
      `ads _id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `ads_id_saison` int(10) NOT NULL,
      `ads_id_adherent` int(11) NOT NULL,
      `ads_licence` tinyint(1) NOT NULL DEFAULT 0,
      `ads_id_licence` int(11) NOT NULL DEFAULT 1,
      `ads_numb_licence` varchar(20) DEFAULT NULL,
      `ads_date_licence` date DEFAULT NULL,
      `ads_certif` tinyint(1) NOT NULL DEFAULT 0,
      `ads_date_certif` date DEFAULT NULL,
      `ads_cotisation` int(11) NOT NULL DEFAULT 0,
      `ads_id_cotisation` int(11) NOT NULL DEFAULT 1,
      `ads_date_cotisation` date DEFAULT NULL,
      `ads_montant_cotisation` int(3) DEFAULT NULL,
      `ads_photo` varchar(20) DEFAULT NULL,
      `ads_nom_modif` varchar(255) NOT NULL DEFAULT 0,
      `ads_date_modif` date DEFAULT NULL,
      `ads_date_modif_cotisation` date DEFAULT NULL,
      `ads_supp` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
