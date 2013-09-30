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