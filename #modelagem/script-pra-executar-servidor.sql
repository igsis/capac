USE capac_new;

INSERT INTO `tipos_contratacoes` (`id`, `tipo_contratacao`) VALUES ('11', 'Fomentos');

ALTER TABLE `tipos_contratacoes`
    CHANGE COLUMN `id` `id` TINYINT(1) NOT NULL AUTO_INCREMENT FIRST;

ALTER TABLE `fom_editais`
	ADD COLUMN `pessoa_tipos_id` TINYINT(1) NOT NULL AFTER `tipo_contratacao_id`;

UPDATE `fom_editais` SET pessoa_tipos_id = 2;

INSERT INTO `pessoa_tipos` (`pessoa`) VALUES ('Ambos');

ALTER TABLE `fom_editais`
	ADD INDEX `fk_fom_editais_pessoa_tipos1_idx` (`pessoa_tipos_id`),
	ADD CONSTRAINT `fk_fom_editais_pessoa_tipos1` FOREIGN KEY (`pessoa_tipos_id`) REFERENCES `pessoa_tipos` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE `fom_projetos`
    CHANGE COLUMN `instituicao` `instituicao` VARCHAR(80) NULL DEFAULT NULL AFTER `protocolo`,
    CHANGE COLUMN `site` `site` VARCHAR(50) NULL DEFAULT NULL AFTER `pessoa_fisica_id`,
    CHANGE COLUMN `nucleo_artistico` `nucleo_artistico` LONGTEXT NULL DEFAULT NULL AFTER `duracao`,
    CHANGE COLUMN `representante_nucleo` `representante_nucleo` VARCHAR(100) NULL DEFAULT NULL AFTER `nucleo_artistico`;


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



ALTER TABLE `contratacao_documentos`
    ADD COLUMN `obrigatorio` TINYINT(1) NOT NULL DEFAULT '1' AFTER `ordem`;

INSERT INTO `fom_editais` (`id`, `tipo_contratacao_id`, `pessoa_tipos_id`, `titulo`, `descricao`, `data_publicacao`, `valor_max_projeto`, `valor_edital`, `data_abertura`, `data_encerramento`, `publicado`) VALUES (4, 11, 1, '1ª EDIÇÃO DE APOIO AOS BLOCOS COMUNITÁRIOS DE CARNAVAL DE RUA', '<ol>\r\n    <li><strong>Data:</strong> 13/03/2020 a 13/04/2020</li>\r\n    <li><strong>Aonde se inscrever:</strong> http://smcsistemas.prefeitura.sp.gov.br/capac/</li>\r\n    <li><strong>Objetivo do Edital: </strong>apoiar coletivos que possuem histórico de atuação em atividades\r\n        carnavalescas através de blocos comunitários de rua na cidade de São Paulo. Tal apoio\r\n        se dará através de fomento as melhores propostas de atividades que envolvam os\r\n        blocos comunitários de carnaval e que tenham o intuito de agregar esta liguagens na\r\n        pauta da cultura da cidade de São Paulo;</li>\r\n    <li><strong>Valores do Edital: </strong>R$ 1.000.000,00</li>\r\n    <li><strong>Valor por projeto: </strong>R$ 50.000,00</li>\r\n    <li><strong>Selecionados: </strong>Até 20 projetos formados por coletivos (pessoa física) de, no mínimo, 3\r\n        pessoas.</li>\r\n    <li><strong>Contrapartida obrigatória: </strong>4 (quatro) oficinas gratuitas em equipamentos públicos\r\n        municipais da Secretaria Municipal de Cultura e 2 (dois) ensaio aberto e gratuitos em\r\n        diferentes equipamentos públicos municipais da Secretaria Municipal de Cultura\r\n        Ainda, deverão ser, obrigatoriamente, selecionados pelo menos 2 (dois) projeto por\r\n        macrorregião da cidade de São Paulo. Consideram-se as seguintes macrorregiões, conforme\r\n        descrição por zona e subprefeitura abaixo:</li>\r\n    <li><strong>Região Centro: </strong>Subprefeitura Sé. / <strong>Região Norte I: </strong>Subprefeituras Jaçanã/Tremembé,\r\n        Santana/Tucuruvi e Vila Maria/Vila Guilherme. / <strong>Região Norte II: </strong>Subprefeituras Casa\r\n        Verde/Cachoeirinha, Freguesia/ Brasilândia, Perus e Pirituba. / <strong>Região Leste I:</strong>\r\n        Subprefeituras Aricanduva/Formosa/Carrão, Mooca, Penha, Sapopemba e Vila\r\n        Prudente. / <strong>Região Leste II: </strong>Subprefeituras Cidade Tiradentes, Ermelino Matarazzo,\r\n        Guaianases, Itaim Paulista, Itaquera, São Mateus e São Miguel. / <strong>Região Sul I:</strong>\r\n        Subprefeituras Ipiranga, Jabaquara e Vila Mariana. / <strong>Região Sul II: </strong>Subprefeituras\r\n        Campo Limpo, Capela do Socorro, Cidade Ademar, M’Boi Mirim, Parelheiros e Santo\r\n        Amaro. / <strong>Região Oeste: </strong>subprefeituras Butantã, Lapa e Pinheiros.</li>\r\n    <li><strong>Comissão: </strong>composta por 5 membros, sendo um servidor público da SMC. Todos\r\n        escolhidos pelo Secretario.</li>\r\n</ol>', '2020-03-10 16:50:20', 50000.00, 1000000.00, '2020-03-13 00:01:00', '2020-04-13 23:59:59', 1);

INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Ficha Síntese', 'ficsin');
INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Declaração Única', 'decunica');
INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Declaração de Uso de Nome Social', 'decnomsoc');
INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Declaração de Utilização de Recursos do Projeto', 'decrecproj');
INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Carta de Anuência', 'cartaanu');

INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 2, 'Anexo I', 1, 1);
INSERT INTO `capac_new`.`contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`) VALUES ('11', '20', 'Anexo II', '2');
INSERT INTO `capac_new`.`contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`) VALUES ('11', '21', 'Anexo III', '3');
INSERT INTO `capac_new`.`contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES ('11', '22', 'Anexo IV', '4', '0');
INSERT INTO `capac_new`.`contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`) VALUES ('11', '23', 'Anexo V', '5');
INSERT INTO `capac_new`.`contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`) VALUES ('11', '24', 'Anexo VI', '6');