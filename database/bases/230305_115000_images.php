<?php

return
    'CREATE TABLE `t_image` (
      `img_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `img_nom` varchar(255) NOT NULL,
      `img_nom_modif` varchar(255) NOT NULL DEFAULT 0,
      `img_date_modif` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
