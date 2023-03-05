<?php

return
    'CREATE TABLE `t_sponsor` (
  `spo_id` int(11) NOT NULL,
  `spo_nom` varchar(250) NOT NULL,
  `spo_numb` varchar(10) DEFAULT NULL,
  `spo_rue` varchar(250) DEFAULT NULL,
  `spo_cp` varchar(6) DEFAULT NULL,
  `spo_ville` varchar(250) DEFAULT NULL,
  `spo_tel` varchar(20) DEFAULT NULL,
  `spo_mail` varchar(50) DEFAULT NULL,
  `spo_site` varchar(50) DEFAULT NULL,
  `spo_logo` varchar(250) NOT NULL,
  `spo_description` varchar(5000) NOT NULL,
  `spo_id_domaine` int(3) NOT NULL,
  `spo_id_section` int(2) NOT NULL,
  `spo_nom_modif` varchar(250) NOT NULL,
  `spo_supplogiq` tinyint(1) NOT NULL DEFAULT 0,
  `spo_date_modif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
