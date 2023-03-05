<?php

return
    'CREATE TABLE `t_membre_h` (
      `mem_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `mem_nom` varchar(50) NOT NULL,
      `mem_prenom` varchar(50) NOT NULL,
      `mem_id_civilite` int(11) NOT NULL,
      `mem_date_birth` date DEFAULT NULL,
      `mem_date_death` date DEFAULT NULL,
      `mem_bio` varchar(500) NOT NULL,
      `mem_photo` varchar(255) NOT NULL DEFAULT \'images/portrait/inconnu.jpg\',
      `mem_nom_modif` varchar(50) NOT NULL,
      `mem_date_modif` date NOT NULL,
      `mem_supplogiq` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
