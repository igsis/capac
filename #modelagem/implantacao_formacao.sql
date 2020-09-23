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

INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (1, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (2, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (3, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (4, 1);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (1, 2);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (2, 2);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (3, 2);
INSERT INTO `cargo_programa` (`form_cargo_id`, `form_programa_id`) VALUES (5, 2);