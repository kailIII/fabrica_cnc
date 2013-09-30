## COMMIT PROGRAMADA PRIMERA PAG DE BRIEF
CREATE TABLE `ab1255_fabrica`.`prop_areas` (
  `id_area` INT NOT NULL AUTO_INCREMENT,
  `nom_area` VARCHAR(255) NULL,
  PRIMARY KEY (`id_area`));

INSERT INTO `ab1255_fabrica`.`prop_areas` (`nom_area`) VALUES ('Planeación');
INSERT INTO `ab1255_fabrica`.`prop_areas` (`nom_area`) VALUES ('Campo');
INSERT INTO `ab1255_fabrica`.`prop_areas` (`nom_area`) VALUES ('Procesamiento');
INSERT INTO `ab1255_fabrica`.`prop_areas` (`nom_area`) VALUES ('Análisis');

ALTER TABLE `ab1255_fabrica`.`prop_calendario` 
ADD COLUMN `id_area` INT NULL AFTER `estado`;

ALTER TABLE `ab1255_fabrica`.`prop_calendario` 
ADD INDEX `fk_prop_areas_id_area_idx` (`id_area` ASC);
ALTER TABLE `ab1255_fabrica`.`prop_calendario` 
ADD CONSTRAINT `fk_prop_areas_id_area`
  FOREIGN KEY (`id_area`)
  REFERENCES `ab1255_fabrica`.`prop_areas` (`id_area`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;


  ALTER TABLE `ab1255_fabrica`.`prop_seg_metodologia_rta` 
ADD COLUMN `id_area` INT NULL AFTER `duracion`;


ALTER TABLE `ab1255_fabrica`.`prop_seg_metodologia_rta` 
ADD INDEX `fk_prop_areas_id_area_idx` (`id_area` ASC);
ALTER TABLE `ab1255_fabrica`.`prop_seg_metodologia_rta` 
ADD CONSTRAINT `fk_propareas_id_area`
  FOREIGN KEY (`id_area`)
  REFERENCES `ab1255_fabrica`.`prop_areas` (`id_area`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

ALTER TABLE `ab1255_fabrica`.`prop_inversion` 
ADD COLUMN `id_area` INT NULL AFTER `tabla`;

ALTER TABLE `ab1255_fabrica`.`prop_inversion` 
ENGINE = InnoDB ;

ALTER TABLE `ab1255_fabrica`.`prop_inversion` 
ADD INDEX `fk_prop_areas_id_areas_idx` (`id_area` ASC);
ALTER TABLE `ab1255_fabrica`.`prop_inversion` 
ADD CONSTRAINT `fk_prop_areas_id_areas`
  FOREIGN KEY (`id_area`)
  REFERENCES `ab1255_fabrica`.`prop_areas` (`id_area`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

## COMMIT BRIEF GUARDA MOTIVOS DE CAMBIO EN BD

  CREATE TABLE `prop_reg_cambios` (
  `id_reg_cambio` int(11) NOT NULL AUTO_INCREMENT,
  `id_propuesta` int(1) unsigned NOT NULL,
  `motivos_cambio` text,
  `id_equipo_cnc` smallint(1) unsigned NOT NULL,
  PRIMARY KEY (`id_reg_cambio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `ab1255_fabrica`.`prop_reg_cambios` 
CHANGE COLUMN `id_equipo_cnc` `id_equipo_cnc` SMALLINT(1) UNSIGNED NULL ;

ALTER TABLE `ab1255_fabrica`.`prop_reg_cambios` 
ADD COLUMN `nombre_responsable` VARCHAR(255) NOT NULL AFTER `id_equipo_cnc`;

ALTER TABLE `ab1255_fabrica`.`prop_reg_cambios` 
ADD INDEX `fk_prop_equipo_cnc_id_idx` (`id_equipo_cnc` ASC);
ALTER TABLE `ab1255_fabrica`.`prop_reg_cambios` 
ADD CONSTRAINT `fk_prop_equipo_cnc_id`
  FOREIGN KEY (`id_equipo_cnc`)
  REFERENCES `ab1255_fabrica`.`prop_equipo_cnc` (`id`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

ALTER TABLE `ab1255_fabrica`.`prop_reg_cambios` 
ADD INDEX `fk_prop_propuesta_id_propuesta_idx` (`id_propuesta` ASC);
ALTER TABLE `ab1255_fabrica`.`prop_reg_cambios` 
ADD CONSTRAINT `fk_prop_propuesta_id_propuesta`
  FOREIGN KEY (`id_propuesta`)
  REFERENCES `ab1255_fabrica`.`prop_propuesta` (`id_propuesta`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `ab1255_fabrica`.`prop_reg_cambios` 
ADD COLUMN `fecha_cambio` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `nombre_responsable`;
