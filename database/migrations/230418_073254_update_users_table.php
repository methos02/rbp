<?php

return '
    ALTER TABLE t_adherent RENAME COLUMN adh_id TO id;
    ALTER TABLE t_adherent RENAME COLUMN adh_prenom TO firstname;
    ALTER TABLE t_adherent RENAME COLUMN adh_nom TO lastname;
    ALTER TABLE t_adherent RENAME COLUMN adh_mail TO email;
    ALTER TABLE t_adherent RENAME COLUMN adh_cle TO token;
    ALTER TABLE t_adherent RENAME COLUMN adh_mdp TO password;
    ALTER TABLE t_adherent RENAME COLUMN adh_section TO section_id;
    ALTER TABLE t_adherent RENAME COLUMN adh_droit TO roles;

    ALTER TABLE t_adherent DROP COLUMN adh_birth;
    ALTER TABLE t_adherent DROP COLUMN adh_civilite;
    ALTER TABLE t_adherent DROP COLUMN adh_sexe;
    ALTER TABLE t_adherent DROP COLUMN adh_nationalite;
    ALTER TABLE t_adherent DROP COLUMN adh_numb;
    ALTER TABLE t_adherent DROP COLUMN adh_rue;
    ALTER TABLE t_adherent DROP COLUMN adh_cp;
    ALTER TABLE t_adherent DROP COLUMN adh_ville;
    ALTER TABLE t_adherent DROP COLUMN adh_numb2;
    ALTER TABLE t_adherent DROP COLUMN adh_rue2;
    ALTER TABLE t_adherent DROP COLUMN adh_cp2;
    ALTER TABLE t_adherent DROP COLUMN adh_ville2;
    ALTER TABLE t_adherent DROP COLUMN adh_tel;
    ALTER TABLE t_adherent DROP COLUMN adh_gsm;
    ALTER TABLE t_adherent DROP COLUMN adh_mail_pere;
    ALTER TABLE t_adherent DROP COLUMN adh_mail_mere;    
    ALTER TABLE t_adherent DROP COLUMN adh_gsm_pere;
    ALTER TABLE t_adherent DROP COLUMN adh_gsm_mere;
    ALTER TABLE t_adherent DROP COLUMN adh_inscrit;
    ALTER TABLE t_adherent DROP COLUMN adh_preinscrit;
    ALTER TABLE t_adherent DROP COLUMN adh_date_in;
    ALTER TABLE t_adherent DROP COLUMN adh_supplogiq;
    ALTER TABLE t_adherent DROP COLUMN adh_nom_modif;
    ALTER TABLE t_adherent DROP COLUMN adh_date_modif;

    ALTER TABLE t_adherent MODIFY roles CHAR(10);

    ALTER TABLE t_adherent RENAME users;
';
