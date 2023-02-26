ALTER TABLE `t_piscine` CHANGE `pis_ID` `pis_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `t_competition` CHANGE `com_ID` `com_id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `com_ID_saison` `com_id_saison` INT(5) NOT NULL, CHANGE `com_ID_section` `com_id_section` INT(2) NOT NULL;
ALTER TABLE `t_sponsor` CHANGE `spo_ID` `spo_id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `spo_ID_domaine` `spo_id_domaine` INT(3) NOT NULL, CHANGE `spo_ID_section` `spo_id_section` INT(2) NOT NULL;
ALTER TABLE `t_piscine` ADD `pis_nom_wpo` VARCHAR(255) NULL DEFAULT NULL AFTER `pis_id`;

ALTER TABLE `t_match` CHANGE `mac_ID` `mac_id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `mac_ID_saison` `mac_id_saison` INT(11) NOT NULL, CHANGE `mac_ID_categorie` `mac_id_categorie` INT(11) NOT NULL;
ALTER TABLE `t_match` ADD `mac_id_wpo` INT NULL DEFAULT NULL AFTER `mac_id`;
ALTER TABLE `t_match` ADD `mac_club_in` VARCHAR(255) NOT NULL AFTER `mac_maj`;
ALTER TABLE `t_match` ADD `mac_initiale_in` VARCHAR(10) NOT NULL AFTER `mac_club_in`;
ALTER TABLE `t_match` ADD `mac_initiale_out` VARCHAR(10) NOT NULL AFTER `mac_club_out`;

UPDATE t_match
LEFT JOIN t_club_piscine ON mac_id_club_piscine = clp_id
LEFT JOIN t_club ON clp_id_club = club_ID
SET mac_club_in = club_nom, mac_initiale_in = club_initiale;

UPDATE t_match
LEFT JOIN t_club ON mac_club_out = club_ID
SET mac_club_out = club_nom, mac_initiale_out = club_initiale;

ALTER TABLE `t_match` ADD `mac_score` VARCHAR(255) NULL DEFAULT NULL AFTER `mac_club_out`;

UPDATE t_match SET mac_score = CONCAT(mac_score_in,' - ',mac_score_out);
ALTER TABLE `t_match` DROP `mac_maj`;
ALTER TABLE `t_match` DROP `mac_score_in`;
ALTER TABLE `t_match` DROP `mac_score_out`;
ALTER TABLE `t_match` DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `t_match` ADD `mac_id_piscine` INT NULL DEFAULT NULL AFTER `mac_rdv`;
ALTER TABLE `t_match` DROP `mac_rdv`;

UPDATE t_match
LEFT JOIN t_club_piscine ON clp_id = mac_id_club_piscine
SET mac_id_piscine = clp_id_piscine;

ALTER TABLE `t_match` DROP `mac_id_club_piscine`;
DROP TABLE `t_conf`;
ALTER TABLE `t_categorie` CHANGE `cat_id` `cat_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `t_categorie` CHANGE `cat_unique` `cat_unique` INT(11) NOT NULL DEFAULT '0';
DROP TABLE `t_club_piscine`;
ALTER TABLE `t_match` ADD `mac_arbitre` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `mac_score`;
ALTER TABLE `t_match` ADD `mac_coupe` BOOLEAN NOT NULL DEFAULT FALSE AFTER `mac_id_wpo`;
ALTER TABLE `t_match` ADD UNIQUE(`mac_id_wpo`);
ALTER TABLE `t_match` DROP `mac_nom_modif`;
ALTER TABLE `t_match` DROP `mac_statut`;
ALTER TABLE `t_match` DROP `mac_resume`;
ALTER TABLE `t_match` ADD `mac_numb` INT NOT NULL AFTER `mac_id_wpo`;

UPDATE `t_competition` SET `com_date_modif`= null WHERE `com_date_modif` = '0000-00-00';
ALTER TABLE `t_competition` CHANGE `com_date_modif` `com_date_modif` DATETIME NULL DEFAULT NULL;
ALTER TABLE `t_competition` CHANGE `com_id_piscine` `com_id_piscine` INT(11) NULL DEFAULT NULL;

ALTER TABLE `t_album` ADD `alb_slug` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `alb_nom`;

/* */
