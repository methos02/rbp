<?php

return
    'CREATE TABLE `t_article` (
      `art _id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `art_id_section` int(11) NOT NULL,
      `art_nom` varchar(25) CHARACTER SET utf8 NOT NULL,
      `art_article` text CHARACTER SET utf8 NOT NULL,
      `art_nom_modif` varchar(25) CHARACTER SET utf8 NOT NULL,
      `art_date_modif` date NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
