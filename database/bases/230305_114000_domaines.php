<?php

return
    'CREATE TABLE `t_domaine` (
      `dom_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `dom_nom` varchar(250) NOT NULL,
      `dom_nom_modif` varchar(250) NOT NULL,
      `dom_date_modif` date NOT NULL,
      `dom_supplogiq` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
