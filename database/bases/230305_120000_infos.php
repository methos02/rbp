<?php

return
    'CREATE TABLE `t_info` (
      `inf_visiteur` int(11) NOT NULL,
      `inf_calendar_mail` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
