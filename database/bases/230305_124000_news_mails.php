<?php

return
    'CREATE TABLE `t_news_mail` (
      `nel _id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `nel_mail` varchar(255) NOT NULL,
      `nel_cle` varchar(32) NOT NULL,
      `nel_supp` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
