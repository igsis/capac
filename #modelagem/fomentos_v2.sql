USE capac_new;

CREATE TABLE `fom_projeto_dados` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `fom_projeto_id` INT NOT NULL,
    `instituicao` VARCHAR(80) NULL DEFAULT NULL,
    `site` VARCHAR(50) NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `fom_projeto_id` (`fom_projeto_id`),
    CONSTRAINT `fk_fom_projeto_dados_fom_projetos` FOREIGN KEY (`fom_projeto_id`) REFERENCES `fom_projetos` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
);

INSERT INTO fom_projeto_dados (fom_projeto_id, instituicao, site) SELECT id, instituicao, site FROM fom_projetos WHERE instituicao IS NOT NULL AND site IS NOT NULL;

CREATE TABLE `integrantes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(70) NOT NULL,
    `rg` VARCHAR(20) NOT NULL,
    `cpf` CHAR(14) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `fom_projeto_nucleo_artistico` (
    `fom_projeto_id` INT NOT NULL,
    `integrante_id` INT NOT NULL,
    INDEX `fom_projeto_id_integrante_id` (`fom_projeto_id`, `integrante_id`),
    CONSTRAINT `fk_projeto` FOREIGN KEY (`fom_projeto_id`) REFERENCES `fom_projetos` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
    CONSTRAINT `fk_nucleo_artistico` FOREIGN KEY (`integrante_id`) REFERENCES `integrantes` (`id`) ON UPDATE NO ACTION
);

ALTER TABLE `fom_projetos`
    ADD COLUMN `nome_projeto` VARCHAR(70) NULL DEFAULT NULL AFTER `valor_projeto`,
    ADD COLUMN `nome_nucleo` VARCHAR(70) NULL DEFAULT NULL AFTER `duracao`,
    ADD COLUMN `coletivo_produtor` VARCHAR(100) NULL DEFAULT NULL AFTER `representante_nucleo`,
    DROP COLUMN `instituicao`,
    DROP COLUMN `site`;

UPDATE `fom_projetos` AS fp
    INNER JOIN `fom_pf_dados` AS fpd ON fp.pessoa_fisica_id = fpd.pessoa_fisicas_id
    SET fp.nome_nucleo = fpd.nome_grupo;

ALTER TABLE `fom_pf_dados`
    DROP COLUMN `nome_grupo`;

INSERT INTO `generos` (`genero`) VALUES ('Não Declarar');
UPDATE `etnias` SET `descricao`='Não Declarar', `publicado`='1' WHERE `id`=1;

alter table pf_detalhes
    add trans tinyint default 0 null;

alter table pf_detalhes
    add pcd tinyint default 0 null;

UPDATE `form_cargos` SET `cargo` = 'Articulador de Processos Artístico-Pedagógicos' WHERE `form_cargos`.`id` = 7;

INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES
(24, 'Anexo II a IV (arquivo único)', 'f-anxII-IV', 0, 1, 1),
(25, 'Anexo V (carta de intenção)', 'f-anexoV', 0, 1, 1),
(26, 'Anexo VI (somente para opção de cotas étnico-raciais)', 'f-anexoVI', 0, 0, 1),
(27, 'Anexo VII (somente para declarar opção de uso do nome social)', 'f-anexoVII', 0, 0, 1),
(28, 'Laudo médico com CID (somente para pessoa com deficiência)', 'f-laudopcd', 0, 0, 1),
(29, 'ANEXO VIII: Indicação de Membros da Sociedade Civil para a Comissão de Seleção', 'f-anxVIII', 0, 1, 1);

UPDATE `etnias` SET `descricao` = 'Parda' WHERE `etnias`.`id` = 2;