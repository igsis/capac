SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `pf_oficinas` DROP INDEX `fk_pf_oficina_oficina_niveis1_idx`;
ALTER TABLE `pf_oficinas` DROP INDEX `fk_pf_oficina_oficina_linguagens1_idx`;
ALTER TABLE `pf_oficinas` DROP INDEX `fk_pf_oficina_oficina_sublinguagens1_idx`;

ALTER TABLE capac_new.pf_oficinas DROP FOREIGN KEY fk_pf_oficina_oficina_linguagens1;
ALTER TABLE capac_new.pf_oficinas DROP FOREIGN KEY fk_pf_oficina_oficina_niveis1;
ALTER TABLE capac_new.pf_oficinas DROP FOREIGN KEY fk_pf_oficina_oficina_sublinguagens1;
ALTER TABLE capac_new.pf_oficinas DROP FOREIGN KEY fk_pf_oficina_pessoa_fisicas1;

DROP TABLE `capac_new`.`pf_oficinas`;

ALTER TABLE `pj_oficinas` DROP INDEX `fk_pj_oficina_oficina_niveis1_idx`;
ALTER TABLE `pj_oficinas` DROP INDEX `fk_pj_oficina_oficina_linguagens1_idx`;
ALTER TABLE `pj_oficinas` DROP INDEX `fk_pj_oficina_oficina_sublinguagens1_idx`;

ALTER TABLE capac_new.pj_oficinas DROP FOREIGN KEY fk_pj_oficina_oficina_linguagens1;
ALTER TABLE capac_new.pj_oficinas DROP FOREIGN KEY fk_pj_oficina_oficina_niveis1;
ALTER TABLE capac_new.pj_oficinas DROP FOREIGN KEY fk_pj_oficina_oficina_sublinguagens1;
ALTER TABLE capac_new.pj_oficinas DROP FOREIGN KEY fk_pj_oficina_pessoa_juridicas1;

DROP TABLE `capac_new`.`pj_oficinas`;

RENAME TABLE `capac_new`.`oficinas` TO `capac_new`.`ofic_cadastros`;
RENAME TABLE `capac_new`.`oficina_linguagens` TO `capac_new`.`ofic_linguagens`;
RENAME TABLE `capac_new`.`oficina_niveis` TO `capac_new`.`ofic_niveis`;
RENAME TABLE `capac_new`.`oficina_sublinguagens` TO `capac_new`.`ofic_sublinguagens`;

ALTER TABLE `ofic_cadastros` ADD `ofic_nivel_id` TINYINT(1) NOT NULL AFTER `execucao_dia2_id`, ADD `ofic_linguagem_id` TINYINT(1) NOT NULL AFTER `ofic_nivel_id`, ADD `ofic_sublinguagem_id` TINYINT(1) NOT NULL AFTER `ofic_linguagem_id`;

ALTER TABLE `ofic_cadastros` ADD CONSTRAINT `fk_oficinas_ofic_nivel` FOREIGN KEY (`ofic_nivel_id`) REFERENCES `ofic_niveis`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `ofic_cadastros` ADD CONSTRAINT `fk_oficinas_ofic_linguagem` FOREIGN KEY (`ofic_linguagem_id`) REFERENCES `ofic_linguagens`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `ofic_cadastros` ADD CONSTRAINT `fk_oficinas_ofic_sublinguagem` FOREIGN KEY (`ofic_sublinguagem_id`) REFERENCES `ofic_sublinguagens`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `eventos` ADD `protocolo` CHAR(18) NOT NULL AFTER `id`;

SET FOREIGN_KEY_CHECKS = 1;