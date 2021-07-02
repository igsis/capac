USE capac_new;

INSERT INTO capac_modulos (id, modulo) VALUES ('7', 'Formação (PIAPI)');

INSERT INTO form_regioes_preferenciais (id, regiao) VALUES ('0', 'Não aplicável');

CREATE TABLE `form_tipo_aberturas` (
    `id` TINYINT(1) NOT NULL AUTO_INCREMENT,
    `tipo_abertura` VARCHAR(16) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);
INSERT INTO `form_tipo_aberturas` (`id`, `tipo_abertura`) VALUES (1, 'Vocacional / Piá');
INSERT INTO `form_tipo_aberturas` (`id`, `tipo_abertura`) VALUES (2, 'Piapi');

ALTER TABLE `form_aberturas`
    ADD COLUMN `tipo_abertura_id` TINYINT(1) NOT NULL DEFAULT '1' AFTER `data_encerramento`,
    ADD INDEX `tipo_abertura_id` (`tipo_abertura_id`),
    ADD CONSTRAINT `form_abertura_tipo_abertura_fk` FOREIGN KEY (`tipo_abertura_id`) REFERENCES `form_tipo_aberturas` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION;


USE siscontrat;

INSERT INTO `programas` (`id`, `programa`, `verba_id`, `edital`, `descricao`, `publicado`) VALUES (3, 'Piapi', 19, 'Edital 026/2020 - SMC/CFOC/SFC', 'O PIÁ atende crianças e jovens de 5 a 14 anos. A proposta artístico-pedagógica do PIÁ considera na sua abordagem as sensações, sentimentos, conceitos, valores e significados culturais e sociais. As brincadeiras, experimentações e vivências entre artistas-educadores, crianças e jovens geram os processos artísticos que revelam, em suas incessantes transformações, o desenvolvimento da sensibilidade, percepção e imaginação.', 1);

INSERT INTO `cargo_programas` (`formacao_cargo_id`, `programa_id`) VALUES (1, 3);
INSERT INTO `cargo_programas` (`formacao_cargo_id`, `programa_id`) VALUES (5, 3);

