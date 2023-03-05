<?php

return
    'CREATE TABLE `t_photo` (
      `pho_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `pho_photo` varchar(255) NOT NULL,
      `pho_id_album` int(10) NOT NULL,
      `pho_nom_modif` varchar(255) NOT NULL,
      `pho_date_modif` date NOT NULL,
      `pho_supplogique` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
