<?php

return
    'CREATE TABLE `t_cs` (
      `cs _id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `cs_id_update` varchar(30) NOT NULL,
      `cs_id_adherent` int(11) NOT NULL,
      `cs_id_section` int(11) NOT NULL,
      `cs_supp` tinyint(1) NOT NULL DEFAULT 0,
      `cs_nom_modif` varchar(40) NOT NULL,
      `cs_date_modif` date NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
