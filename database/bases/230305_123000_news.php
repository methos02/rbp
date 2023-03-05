<?php

return
    'CREATE TABLE `t_news` (
      `news_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `news_titre` varchar(255) NOT NULL,
      `news_news` text NOT NULL,
      `news_photo` varchar(255) NOT NULL,
      `news_nom_posteur` varchar(255) NOT NULL,
      `news_date_p` datetime NOT NULL,
      `news_ID_section` int(255) NOT NULL,
      `news_nom_modif` varchar(255) DEFAULT NULL,
      `news_date_modif` datetime DEFAULT NULL,
      `news_supplogiq` int(11) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
