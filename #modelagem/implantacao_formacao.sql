set foreign_key_checks = 0;

create table capac_modulos
(
    id tinyint(2) auto_increment,
    modulo varchar(100) null,
    constraint capac_modulos_pk
        primary key (id)
);

INSERT INTO `capac_modulos` (`id`, `modulo`) VALUES
(1, 'Evento com cachê'),
(2, 'Evento sem cachê'),
(3, 'Emenda parlamentar'),
(4, 'Oficinas'),
(5, 'Formação (Piá e Vocacional)'),
(6, 'Fomentos');

create table form_aberturas
(
    id tinyint auto_increment,
    titulo varchar(100) null,
    descricao longtext null,
    data_publicacao datetime null,
    data_abertura datetime null,
    data_encerramento datetime null,
    publicado tinyint default 1 null,
    constraint form_aberturas_pk
        primary key (id)
);

ALTER TABLE `form_cadastros` ADD `data_envio` DATETIME NOT NULL AFTER `usuario_id`;

alter table pf_detalhes drop column curriculo;
ALTER TABLE `pf_detalhes` DROP INDEX `fk_detalhesPessoaFisica_regioes1_idx`;
ALTER TABLE capac_new.pf_detalhes DROP FOREIGN KEY fk_detalhesPessoaFisica_regioes1;
ALTER TABLE `pf_detalhes` DROP `regiao_id`;

alter table form_aberturas
    add ano_referencia smallint(4) null after descricao;

CREATE TABLE `cargo_programa` (
                                  `form_cargo_id` TINYINT(2) NOT NULL,
                                  `form_programa_id` TINYINT(2) NOT NULL,
                                  INDEX `form_cargo_id_form_programa_id` (`form_cargo_id`, `form_programa_id`),
                                  CONSTRAINT `cargo_programa_form_cargos` FOREIGN KEY (`form_cargo_id`) REFERENCES `form_cargos` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
                                  CONSTRAINT `cargo_programa_form_programas` FOREIGN KEY (`form_programa_id`) REFERENCES `form_programas` (`id`) ON UPDATE NO ACTION
);

UPDATE `form_cargos` SET `cargo`='Articulador de Áreas - Comunicação' WHERE  `id`=3;
INSERT INTO `form_cargos` (`id`, `cargo`, `justificativa`) VALUES (6, 'Articulador de Áreas - Instrumentais e Pesquisa', '');
INSERT INTO `form_cargos` (`id`, `cargo`, `justificativa`) VALUES (7, 'Articulador de Áreas - Ações Artístico-Pedagógicas', '');

INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (1, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (1, 2);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (2, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (2, 2);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (3, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (3, 2);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (4, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (5, 2);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (6, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (7, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (6, 2);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (7, 2);

ALTER TABLE `form_cadastros`
    DROP COLUMN `projeto_id`,
    DROP INDEX `fk_form_pre_pedidos_projetos_idx`,
    DROP FOREIGN KEY `fk_form_pre_pedidos_projetos`;

ALTER TABLE `form_cadastros`
    ADD COLUMN `protocolo` CHAR(18) NULL DEFAULT NULL AFTER `id`,
    CHANGE COLUMN `data_envio` `data_envio` DATETIME NULL DEFAULT NULL AFTER `usuario_id`;

DROP TABLE `form_projetos`;

create table form_lista_documentos
(
    id int auto_increment,
    documento varchar(150) not null,
    sigla varchar(10) not null,
    ordem tinyint(2) default 0 null,
    obrigatorio tinyint(1) default 1 null,
    publicado tinyint(1) default 1 null,
    constraint form_lista_documentos_pk
        primary key (id)
);

create unique index form_lista_documentos_documento_uindex
    on form_lista_documentos (documento);

create unique index form_lista_documentos_sigla_uindex
    on form_lista_documentos (sigla);


create table form_arquivos
(
    id int auto_increment,
    form_lista_documento_id int not null,
    form_cadastro_id int not null,
    arquivo varchar(100) not null,
    data datetime not null,
    publicado tinyint(1) default 1 null,
    constraint form_arquivos_pk
        primary key (id),
    constraint form_arquivos_form_cadastros_id_fk
        foreign key (form_cadastro_id) references form_cadastros (id),
    constraint form_arquivos_form_lista_documentos_id_fk
        foreign key (form_lista_documento_id) references form_lista_documentos (id)
);

INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (1, 'RG/RNE/PASSAPORTE', 'rg', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (2, 'CPF', 'cpf', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (3, 'Comprovante de residência', 'residencia', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (4, 'PIS/PASEP/NIT', 'pis_pasep_', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (5, 'Currículo', 'curriculo', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (6, 'DRT', 'drt', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (7, 'Anexos III a V (arquivo único)', 'anex3a5', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (8, 'Comprovante de formação 1', 'com_form1', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (9, 'Comprovante de formação 2', 'com_form2', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (10, 'Comprovante de formação 3', 'com_form3', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (11, 'Comprovante de formação 4', 'com_form4', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (12, 'Comprovante de experiência artística 1', 'com_art1', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (13, 'Comprovante de experiência artística 2', 'com_art2', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (14, 'Comprovante de experiência artística 3', 'com_art3', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (15, 'Comprovante de experiência artística 4', 'com_art4', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (16, 'Comprovante de experiência artístico-pedagógica 1', 'comartped1', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (17, 'Comprovante de experiência artístico-pedagógica 2', 'comartped2', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (18, 'Comprovante de experiência artístico-pedagógica 3', 'comartped3', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (19, 'Comprovante de experiência artístico-pedagógica 4', 'comartped4', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (20, 'Comprovante de Experiência em Articulação/Coordenação 1', 'comcoord1', 0, 1, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (21, 'Comprovante de Experiência em Articulação/Coordenação 2', 'comcoord2', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (22, 'Comprovante de Experiência em Articulação/Coordenação 3', 'comcoord3', 0, 0, 1);
INSERT INTO `form_lista_documentos` (`id`, `documento`, `sigla`, `ordem`, `obrigatorio`, `publicado`) VALUES (23, 'Comprovante de Experiência em Articulação/Coordenação 4', 'comcoord4', 0, 0, 1);

alter table pf_detalhes
    add genero_id int null after etnia_id;

alter table pf_detalhes
    add constraint pf_detalhes_generos_id_fk
        foreign key (genero_id) references generos (id);

# Manter este comando na última linha
set foreign_key_checks = 1;