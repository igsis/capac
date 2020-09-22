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

create table form_pf_dados
(
    id int auto_increment,
    pessoa_fisica_id int not null,
    etnia_id tinyint(1) null,
    grau_instrucao_id tinyint(1) null,
    constraint form_pf_dados_pk
        primary key (id),
    constraint form_pf_dados_etnias_id_fk
        foreign key (etnia_id) references etnias (id),
    constraint form_pf_dados_grau_instrucoes_id_fk
        foreign key (grau_instrucao_id) references grau_instrucoes (id),
    constraint form_pf_dados_pessoa_fisicas_id_fk
        foreign key (pessoa_fisica_id) references pessoa_fisicas (id)
);