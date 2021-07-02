INSERT INTO capac_modulos (id, modulo) VALUES ('7', 'Formação (PIAPI)');

INSERT INTO form_regioes_preferenciais (id, regiao) VALUES ('0', 'Não aplicável');

CREATE TABLE `form_tipo_aberturas` (
                                       `id` TINYINT(1) NOT NULL AUTO_INCREMENT,
                                       `tipo_abertura` VARCHAR(16) NULL DEFAULT NULL,
                                       PRIMARY KEY (`id`)
);
INSERT INTO `form_tipo_aberturas` (`id`, `tipo_abertura`) VALUES (1, 'Vocacional / Piá');
INSERT INTO `form_tipo_aberturas` (`id`, `tipo_abertura`) VALUES (2, 'Piap');

ALTER TABLE `form_aberturas`
    ADD COLUMN `tipo_abertura_id` TINYINT(1) NOT NULL DEFAULT '1' AFTER `data_encerramento`,
    ADD INDEX `tipo_abertura_id` (`tipo_abertura_id`),
    ADD CONSTRAINT `form_abertura_tipo_abertura_fk` FOREIGN KEY (`tipo_abertura_id`) REFERENCES `form_tipo_aberturas` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION;
