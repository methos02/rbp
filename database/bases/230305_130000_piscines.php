<?php

return
    'CREATE TABLE t_piscine (
    `pis_id` int(11) PRIMARY KEY AUTO_INCREMENT, 
    `pis_nom_wpo` varchar(255) DEFAULT NULL,
    `pis_nom` varchar(256) NOT NULL,
    `pis_numb` varchar(10) DEFAULT NULL,
    `pis_rue` varchar(256) NOT NULL,
    `pis_cp` int(6) NOT NULL,
    `pis_ville` varchar(256) NOT NULL,
    `pis_nom_modif` varchar(256) NOT NULL,
    `pis_date_modif` date NOT NULL,
    `pis_supplogique` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
;
