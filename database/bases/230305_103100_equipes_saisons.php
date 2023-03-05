<?php

return
    'CREATE TABLE `t_equipe_saison` (
      `equ _id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `equ_ID_categorie` int(11) NOT NULL,
      `equ_ID_saison` int(11) NOT NULL,
      `equ_nom_modif` varchar(255) NOT NULL,
      `equ_supp` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
