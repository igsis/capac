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