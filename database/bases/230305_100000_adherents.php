<?php

return
    'CREATE TABLE `t_adherent` (
      `adh_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT PRIMARY KEY AUTO_INCREMENT,
      `adh_nom` varchar(255) NOT NULL,
      `adh_prenom` varchar(255) NOT NULL,
      `adh_birth` date NOT NULL,
      `adh_civilite` varchar(255) NOT NULL,
      `adh_sexe` varchar(20) NOT NULL,
      `adh_nationalite` varchar(255) NOT NULL,
      `adh_numb` varchar(10) DEFAULT NULL,
      `adh_rue` varchar(255) DEFAULT NULL,
      `adh_cp` varchar(255) DEFAULT NULL,
      `adh_ville` varchar(255) DEFAULT NULL,
      `adh_numb2` varchar(10) DEFAULT NULL,
      `adh_rue2` varchar(255) DEFAULT NULL,
      `adh_cp2` varchar(255) DEFAULT NULL,
      `adh_ville2` varchar(255) DEFAULT NULL,
      `adh_tel` varchar(255) DEFAULT NULL,
      `adh_gsm` varchar(255) DEFAULT NULL,
      `adh_gsm_mere` varchar(255) DEFAULT NULL,
      `adh_gsm_pere` varchar(255) DEFAULT NULL,
      `adh_mail` varchar(255) DEFAULT NULL,
      `adh_mail_mere` varchar(255) DEFAULT NULL,
      `adh_mail_pere` varchar(255) DEFAULT NULL,
      `adh_inscrit` tinyint(1) NOT NULL DEFAULT 0,
      `adh_preinscrit` tinyint(1) NOT NULL DEFAULT 0,
      `adh_date_in` date DEFAULT NULL,
      `adh_droit` int(11) NOT NULL DEFAULT 0,
      `adh_section` varchar(10) DEFAULT NULL,
      `adh_cle` varchar(255) DEFAULT NULL,
      `adh_mdp` varchar(255) DEFAULT NULL,
      `adh_supplogiq` tinyint(1) NOT NULL DEFAULT 0,
      `adh_nom_modif` varchar(20) NOT NULL,
      `adh_date_modif` date DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
