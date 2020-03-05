ALTER TABLE `fom_editais`
	ADD COLUMN `pessoa_tipos_id` TINYINT(1) NOT NULL AFTER `tipo_contratacao_id`;
UPDATE `fom_editais` SET pessoa_tipos_id = 2; 
INSERT INTO `capac_new`.`pessoa_tipos` (`pessoa`) VALUES ('Ambos');
ALTER TABLE `fom_editais`
	ADD INDEX `fk_fom_editais_pessoa_tipos1_idx` (`pessoa_tipos_id`),
	ADD CONSTRAINT `fk_fom_editais_pessoa_tipos1` FOREIGN KEY (`pessoa_tipos_id`) REFERENCES `pessoa_tipos` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION;