<?php

return
    'CREATE TABLE `t_adherent_categorie` (
      `adc_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `adc_id_update` varchar(30) NOT NULL,
      `adc_id_adh_saison` int(11) NOT NULL,
      `adc_id_fonction` int(11) NOT NULL,
      `adc_id_section` int(11) NOT NULL,
      `adc_id_categorie` int(11) NOT NULL DEFAULT 0,
      `adc_nom_modif` varchar(255) NOT NULL,
      `adc_date_modif` date DEFAULT NULL,
      `adc_supp` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
