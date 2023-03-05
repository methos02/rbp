<?php

return
    'CREATE TABLE `t_categorie` (
      `cat _id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `cat_categorie` varchar(20) NOT NULL,
      `cat_id_section` int(11) NOT NULL,
      `cat_id_fonction` int(11) NOT NULL,
      `cat_unique` int(11) NOT NULL DEFAULT 0,
      `cat_id_entente` varchar(250) NOT NULL DEFAULT 0,
      `cat_active` int(11) NOT NULL DEFAULT 0,
      `cat_supplogiq` tinyint(1) NOT NULL DEFAULT 0,
      `cat_nom_modif` varchar(40) NOT NULL,
      `cat_date_modif` date NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
