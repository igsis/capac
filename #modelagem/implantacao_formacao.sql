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