<?php

return
    'CREATE TABLE `t_club` (
      `club_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `club_nom` varchar(255) NOT NULL,
      `club_initiale` varchar(5) NOT NULL,
      `club_nom_modif` varchar(255) DEFAULT NULL,
      `club_date_modif` date DEFAULT NULL,
      `club_supp` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
