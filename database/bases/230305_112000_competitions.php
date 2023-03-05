<?php

return
    'CREATE TABLE `t_competition` (
      `com_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `com_nom` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
      `com_id_saison` int(5) NOT NULL,
      `com_id_section` int(2) NOT NULL,
      `com_statut` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
      `com_date_in` date NOT NULL,
      `com_date_out` date DEFAULT NULL,
      `com_heure` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
      `com_id_piscine` int(11) NOT NULL,
      `com_programme` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
      `com_liste` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
      `com_resultat` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
      `com_nom_creation` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
      `com_date_modif` datetime DEFAULT NULL,
      `com_nom_modif` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `com_supplogiq` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
