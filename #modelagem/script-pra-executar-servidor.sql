ALTER TABLE `fom_editais`
	ADD COLUMN `pessoa_tipos_id` TINYINT(1) NOT NULL AFTER `tipo_contratacao_id`;

UPDATE `fom_editais` SET pessoa_tipos_id = 2;

INSERT INTO `capac_new`.`pessoa_tipos` (`pessoa`) VALUES ('Ambos');

ALTER TABLE `fom_editais`
	ADD INDEX `fk_fom_editais_pessoa_tipos1_idx` (`pessoa_tipos_id`),
	ADD CONSTRAINT `fk_fom_editais_pessoa_tipos1` FOREIGN KEY (`pessoa_tipos_id`) REFERENCES `pessoa_tipos` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `grau_instrucoes`
    ALTER `grau_instrucao` DROP DEFAULT;
ALTER TABLE `grau_instrucoes`
    CHANGE COLUMN `grau_instrucao` `grau_instrucao` VARCHAR(33) NOT NULL AFTER `id`;

UPDATE `capac_new`.`grau_instrucoes` SET `grau_instrucao`='Não concluiu nenhum ciclo escolar' WHERE `id`=6;
INSERT INTO `grau_instrucoes` (`grau_instrucao`) VALUES ('Fundamental');
INSERT INTO `grau_instrucoes` (`grau_instrucao`) VALUES ('Especialização');
INSERT INTO `grau_instrucoes` (`grau_instrucao`) VALUES ('Doutorado');

CREATE TABLE `generos` (
                           `id` INT(11) NOT NULL AUTO_INCREMENT,
                           `genero` VARCHAR(13) NOT NULL,
                           PRIMARY KEY (`id`)
);

INSERT INTO `generos` (`id`, `genero`) VALUES (1, 'Heterossexual');
INSERT INTO `generos` (`id`, `genero`) VALUES (2, 'Homossexual');
INSERT INTO `generos` (`id`, `genero`) VALUES (3, 'Bissexual');
INSERT INTO `generos` (`id`, `genero`) VALUES (4, 'Assexual');
INSERT INTO `generos` (`id`, `genero`) VALUES (5, 'Outro');

CREATE TABLE `subprefeituras` (
                                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                                  `subprefeitura` VARCHAR(25) NOT NULL,
                                  PRIMARY KEY (`id`)
);

INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (1, 'Aricanduva/Formosa/Carrão');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (2, 'Butantã');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (3, 'Campo Limpo');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (4, 'Capela do Socorro');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (5, 'Casa Verde');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (6, 'Cidade Ademar');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (7, 'Cidade Tiradentes');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (8, 'Ermelino Matarazzo');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (9, 'Freguesia/Brasilândia');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (10, 'Guaianases');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (11, 'Ipiranga');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (12, 'Itaim');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (13, 'Paulista');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (14, 'Itaquera');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (15, 'Jabaquara');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (16, 'Jaçanã/Tremembé');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (17, 'Lapa');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (18, 'Mboi Mirim');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (19, 'Mooca');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (20, 'Parelheiros');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (21, 'Penha');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (22, 'Perus');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (23, 'Pinheiros');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (24, 'Pirituba/Jaraguá');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (25, 'Santana/Tucuruvi');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (26, 'Santo Amaro');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (27, 'São Mateus');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (28, 'São Miguel Paulista');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (29, 'Sapopemba');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (30, 'Sé');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (31, 'Vila Maria/Vila Guilherme');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (32, 'Vila Mariana');
INSERT INTO `subprefeituras` (`id`, `subprefeitura`) VALUES (33, 'Vila Prudente');

CREATE TABLE `fom_pf_dados` (
                                `pessoa_fisicas_id` INT(11) NOT NULL,
                                `nome_grupo` VARCHAR(240) NOT NULL,
                                `genero_id` INT(11) NOT NULL,
                                `subprefeitura_id` INT(11) NOT NULL,
                                `etnia_id` TINYINT(1) NOT NULL,
                                `grau_instrucao_id` TINYINT(1) NOT NULL,
                                `rede_social` VARCHAR(120) NULL DEFAULT NULL,
                                PRIMARY KEY (`pessoa_fisicas_id`),
                                INDEX `fk_fom_pf_dados_genero1_idx` (`genero_id`),
                                INDEX `fk_fom_pf_dados_subbprefeitura1_idx` (`subprefeitura_id`),
                                INDEX `fk_fom_pf_dados_etnias1_idx` (`etnia_id`),
                                INDEX `fk_fom_pf_dados_grau_instrucoes1_idx` (`grau_instrucao_id`),
                                CONSTRAINT `fk_fom_pf_dados_etnias1` FOREIGN KEY (`etnia_id`) REFERENCES `etnias` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
                                CONSTRAINT `fk_fom_pf_dados_genero1` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
                                CONSTRAINT `fk_fom_pf_dados_grau_instrucoes1` FOREIGN KEY (`grau_instrucao_id`) REFERENCES `grau_instrucoes` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
                                CONSTRAINT `fk_fom_pf_dados_pessoa_fisicas1` FOREIGN KEY (`pessoa_fisicas_id`) REFERENCES `pessoa_fisicas` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
                                CONSTRAINT `fk_fom_pf_dados_subbprefeitura1` FOREIGN KEY (`subprefeitura_id`) REFERENCES `subprefeituras` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
);
