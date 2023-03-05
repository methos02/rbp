<?php

return
    'CREATE TABLE `t_album` (
      `alb_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `alb_nom` varchar(255) NOT NULL,
      `alb_slug` varchar(255) NOT NULL,
      `alb_cover` varchar(255) DEFAULT NULL,
      `alb_id_saison` int(10) NOT NULL,
      `alb_id_section` int(11) NOT NULL,
      `alb_nom_creation` varchar(255) NOT NULL,
      `alb_date_creation` date NOT NULL,
      `alb_nom_modif` varchar(255) DEFAULT NULL,
      `alb_date_modif` date DEFAULT NULL,
      `alb_supplogique` int(11) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
