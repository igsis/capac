USE capac_new;

ALTER TABLE `form_regioes_preferenciais`
    ADD COLUMN `publicado` TINYINT(1) NOT NULL DEFAULT '1' AFTER `regiao`;

INSERT INTO form_regioes_preferenciais (id, regiao, publicado) VALUES ('0', 'Não aplicável', '0');

CREATE TABLE `form_editais` (
    `id` TINYINT(1) NOT NULL AUTO_INCREMENT,
    `edital` VARCHAR(16) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);
INSERT INTO `form_editais` (`id`, `edital`) VALUES ('1', 'Vocacional / PIÁ'), ('2', 'PIAPI');

ALTER TABLE `form_aberturas` ADD `form_edital_id` TINYINT(1) NOT NULL AFTER `ano_referencia`;

UPDATE `form_aberturas` SET `form_edital_id` = '1' WHERE `form_aberturas`.`id` = 1;

ALTER TABLE `form_aberturas` ADD CONSTRAINT `fk_form_aberturas_form_editais` FOREIGN KEY (`form_edital_id`) REFERENCES `form_editais`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `form_cadastros` ADD `form_edital_id` TINYINT(1) NOT NULL AFTER `ano`;

UPDATE `form_cadastros` SET `form_edital_id` = '1';

ALTER TABLE `form_cadastros` ADD CONSTRAINT `fk_form_cadastros_form_editais` FOREIGN KEY (`form_edital_id`) REFERENCES `form_editais`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;




USE siscontrat;

INSERT INTO `linguagens` (`id`, `linguagem`, `publicado`) VALUES (0, 'Não Aplicável', 0);

INSERT INTO `programas` (`id`, `programa`, `verba_id`, `edital`, `descricao`, `publicado`) VALUES (3, 'PIAPI', 19, 'Edital 000/2021 - SMC/CFOC/SFC', '[DESCRIÇÃO TESTE] O PIÁ atende crianças e jovens de 5 a 14 anos. A proposta artístico-pedagógica do PIÁ considera na sua abordagem as sensações, sentimentos, conceitos, valores e significados culturais e sociais. As brincadeiras, experimentações e vivências entre artistas-educadores, crianças e jovens geram os processos artísticos que revelam, em suas incessantes transformações, o desenvolvimento da sensibilidade, percepção e imaginação.', 1);

INSERT INTO `cargo_programas` (`formacao_cargo_id`, `programa_id`) VALUES (1, 3);
INSERT INTO `cargo_programas` (`formacao_cargo_id`, `programa_id`) VALUES (5, 3);

INSERT INTO `formacao_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (30, 'Anexo I a III (arquivo único)', 'f-anxI-III', 0, 1, 1);
INSERT INTO `formacao_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (31, 'Anexo IV (carta de intenção e link vídeo)', 'f-anexoIV', 0, 1, 1);
INSERT INTO `formacao_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (32, 'Anexo V (somente para opção de cotas étnico-raciais)', 'f-anexoV2', 0, 0, 1);
INSERT INTO `formacao_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (33, 'Anexo VI (somente para declarar opção de uso do nome social)', 'f-anexoVI2', 0, 0, 1);