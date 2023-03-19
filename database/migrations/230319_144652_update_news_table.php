<?php

return '
    ALTER TABLE t_news RENAME COLUMN news_id TO id;
    ALTER TABLE t_news RENAME COLUMN news_titre TO title;
    ALTER TABLE t_news RENAME COLUMN news_news TO content;
    ALTER TABLE t_news RENAME COLUMN news_photo TO picture;
    ALTER TABLE t_news RENAME COLUMN news_nom_posteur TO created_by;
    ALTER TABLE t_news RENAME COLUMN news_date_p TO created_at;
    ALTER TABLE t_news RENAME COLUMN news_ID_section TO section_id;
    ALTER TABLE t_news RENAME COLUMN news_nom_modif TO updated_by;
    ALTER TABLE t_news RENAME COLUMN news_date_modif TO updated_at;
    ALTER TABLE t_news RENAME COLUMN news_supplogiq TO status;
    
    ALTER TABLE t_news MODIFY created_at DATE;
    ALTER TABLE t_news MODIFY updated_at DATE;

    ALTER TABLE t_news RENAME news;
';
