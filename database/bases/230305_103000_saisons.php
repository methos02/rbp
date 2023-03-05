<?php

return
    'CREATE TABLE `t_saison` (
      `sai _id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `sai_saison` varchar(20) NOT NULL,
      `sai_active` tinyint(1) NOT NULL DEFAULT 0,
      `sai_supplogiq` tinyint(1) DEFAULT 0,
      `sai_date_modif` date DEFAULT NULL,
      `sai_nom_modif` varchar(20) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
