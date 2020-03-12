USE capac_new;

INSERT INTO `tipos_contratacoes` (`id`, `tipo_contratacao`) VALUES ('11', 'Fomentos');

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

INSERT INTO `fom_editais` (`id`, `tipo_contratacao_id`, `pessoa_tipos_id`, `titulo`, `descricao`, `data_publicacao`, `valor_max_projeto`, `valor_edital`, `data_abertura`, `data_encerramento`, `publicado`) VALUES (4, 11, 1, '1ª EDIÇÃO DE APOIO AOS BLOCOS DE CARNAVAL DE RUA', '<h5 style="text-align: center; "><span id="docs-internal-guid-51b6666c-7fff-218a-622d-b88099b4adbd"><span style="font-size: 14pt; font-family: Calibri, sans-serif; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">PREFEITURA DO MUNICÍPIO DE SÃO PAULO</span></span></h5><h5 style="text-align: center; "><span id="docs-internal-guid-51b6666c-7fff-218a-622d-b88099b4adbd"><span style="font-size: 14pt; font-family: Calibri, sans-serif; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"><span style="font-weight:normal;" id="docs-internal-guid-53ba6fc9-7fff-4d45-646d-413ea3f942c0"><span style="font-size: 14pt; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline;">SECRETARIA MUNICIPAL DE CULTURA</span></span></span></span></h5><p style="text-align: center; "><br></p><p style="text-align: justify;"><span id="docs-internal-guid-9117894a-7fff-9a6e-dad5-ae8b1c8fe502"><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Edital nº 08/2020/SMC/CFOC/SFA – 1ª EDIÇÃO DE APOIO AOS BLOCOS DE CARNAVAL DE RUA</span></span></p><p style="text-align: justify;"><span id="docs-internal-guid-55113f1a-7fff-f05e-45af-6d4753a0e647"><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Processo SEI n°: 6025.2020/0003108-0</span></span></p><p style="text-align: justify;"><span style="background-color: transparent; font-size: 11pt; font-family: Calibri, sans-serif; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">A PREFEITURA DO MUNICÍPIO DE SÃO PAULO, por meio da SECRETARIA MUNICIPAL DE CULTURA, abre procedimento de chamamento público para a </span><span style="background-color: transparent; font-size: 11pt; font-family: Calibri, sans-serif; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">1ª EDIÇÃO DE APOIO AOS BLOCOS DE CARNAVAL DE RUA, </span><span style="background-color: transparent; font-size: 11pt; font-family: Calibri, sans-serif; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">cujas inscrições estarão abertas no período compreendido entre às 9 horas do dia 13/03/2020 às 18 horas de 13/04/2020, através do link </span><a href="http://smcsistemas.prefeitura.sp.gov.br/capac/" style="background-color: rgb(255, 255, 255); font-size: 1rem;"><span style="font-size: 11pt; font-family: Calibri, sans-serif; color: rgb(0, 0, 255); background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; text-decoration-line: underline; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;">http://smcsistemas.prefeitura.sp.gov.br/capac/</span></a><br></p><span id="docs-internal-guid-ff73e995-7fff-7a31-c69b-dac98cea4dde"><p dir="ltr" style="text-align: justify; line-height: 1.8; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">A </span><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-weight: 700; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">1ª EDIÇÃO DE APOIO AOS BLOCOS DE CARNAVAL DE RUA</span><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"> tem como objetivo apoiar coletivos que possuem histórico de atuação em atividades carnavalescas através de blocos de rua na cidade de São Paulo. Os projetos fomentados deverão ter, obrigatoriamente, atividades de contrapartida nos equipamentos públicos da Secretaria Municipal de Cultura.&nbsp;</span></p><p dir="ltr" style="text-align: justify; line-height: 1.8; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">O valor total deste edital é de R$ 1.000.000,00 (um milhão de reais), dos quais serão pagos em 2 (duas) parcelas:</span></p><p dir="ltr" style="text-align: justify; line-height: 1.8; text-indent: 21.25pt; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"><span class="Apple-tab-span" style="white-space:pre;">	</span></span><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">a. Primeira parcela no valor de 60% (sessenta por cento) do valor do projeto</span></p><p dir="ltr" style="text-align: justify; line-height: 1.8; text-indent: 21.25pt; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;"><span class="Apple-tab-span" style="white-space:pre;">	</span></span><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">b. Segunda parcela no valor de 40% (quarenta por cento) do valor do projeto</span></p><p dir="ltr" style="text-align: justify; line-height: 1.8; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">As propostas apresentadas neste edital poderão ter valor máximo de R$ 50.000,00 (cinquenta mil reais) cada e com duração máxima de até 12 (doze) meses.</span></p><p dir="ltr" style="text-align: justify; line-height: 1.8; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Calibri, sans-serif; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;">Serão apoiados e fomentados neste edital até 20 (vinte) projetos de R$ 50.000,00 (cinquenta mil reais) cada.</span></p></span>', '2020-03-11 13:31:29', 50000.00, 1000000.00, '2020-03-13 09:00:00', '2020-04-13 18:00:00', 1);

INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Ficha Síntese', 'ficsin');
INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Declaração Única', 'decunica');
INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Declaração de Uso de Nome Social', 'decnomsoc');
INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Declaração de Utilização de Recursos do Projeto', 'decrecproj');
INSERT INTO `fom_lista_documentos` (`documento`, `sigla`) VALUES ('Carta de Anuência', 'cartaanu');

INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 1, '', 1, 1);
INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 2, 'Anexo I', 2, 1);
INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 9, NULL, 9, 0);
INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 13, 'Anexo VII', 8, 1);
INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 20, 'Anexo II', 3, 1);
INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 21, 'Anexo III', 4, 1);
INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 22, 'Anexo IV', 5, 0);
INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 23, 'Anexo V', 6, 1);
INSERT INTO `contratacao_documentos` (`tipo_contratacao_id`, `fom_lista_documento_id`, `anexo`, `ordem`, `obrigatorio`) VALUES (11, 24, 'Anexo VI', 7, 1);