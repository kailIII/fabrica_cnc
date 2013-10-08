ALTER TABLE `ab1255_fabrica`.`prop_nivel_aceptacion` 
ADD COLUMN `min` TINYINT(1) NULL AFTER `activo`,
ADD COLUMN `max` TINYINT(1) NULL AFTER `min`;

UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='3' WHERE `id_nivel_aceptacion`='1';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='3' WHERE `id_nivel_aceptacion`='2';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='3' WHERE `id_nivel_aceptacion`='3';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='6' WHERE `id_nivel_aceptacion`='4';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='6' WHERE `id_nivel_aceptacion`='5';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='6' WHERE `id_nivel_aceptacion`='6';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='3', `max`='6' WHERE `id_nivel_aceptacion`='7';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='3', `max`='6' WHERE `id_nivel_aceptacion`='8';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='3', `max`='6' WHERE `id_nivel_aceptacion`='9';
UPDATE `ab1255_fabrica`.`prop_nivel_aceptacion` SET `min`='0', `max`='0' WHERE `id_nivel_aceptacion`='10';

UPDATE `ab1255_fabrica`.`prop_metodologia` SET `a_tam_poblacion`='0' WHERE `id_metodologia`='18';


## --- 
UPDATE prop_metodologia SET titulo_marco_muestral = 'Método de selección del informante' WHERE titulo_marco_muestral = 'Método de selección del cliente'

## LISTO :D

UPDATE `ab1255_fabrica`.`prop_areas` SET `nom_area`='Informe' WHERE `id_area`='4';

CREATE TABLE `prop_incumplimiento` (
  `id_incu` int(11) NOT NULL AUTO_INCREMENT,
  `id_area` int(11) DEFAULT NULL,
  `des_incu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_incu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE  `prop_incumplimiento` ADD INDEX (  `id_area` ) ;
ALTER TABLE  `prop_incumplimiento` ADD CONSTRAINT  `fk_prop_areas_id_area_5` FOREIGN KEY (  `id_area` ) REFERENCES  `ab1255_fabrica`.`prop_areas` (
`id_area`
) ON DELETE SET NULL ON UPDATE CASCADE ;

INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('1', 'Pendiente aprobación formulario por cliente');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('1', 'Pendiente entrega base por cliente');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('1', 'Pendiente elaboración de formulario por director');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('1', 'En Stand-By');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('1', 'Otros');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('2', 'Dificultad para conseguir entrevistados de 5 y 6');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('2', 'Dificultad para conseguir entrevistados especializados');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('2', 'Falta de personal de campo idóneo para el estudio');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('2', 'Base de datos insuficiente');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('2', 'Cartografía desactualizada');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('2', 'Mal tiempo');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('2', 'Problemas de orden público');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('2', 'Otros');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Demora en recibo de material');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Demora en entrega de material');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Demorra de entrega de programa');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Demora en entrega de requerimientos del cliente');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Formulario mal elaborado');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Formulario con muchas preguntas abiertas');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Formulario muy largo');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Formulario con diseño gráfico complicado');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Mala ortografía / letra ilegible de encuestadores');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Estudio de tema muy especializado');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Estudio con verificación de 100% de encuestas');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Falta de códigos del cliente');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Necesidad de nuevo programa de captura para datos adicionales');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Documentación y adecuación de base de datos');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Cambio de versión del formulario');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Base de telescript sin depurar');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Programa de captura del cliente defectuoso');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Cambios en procesamiento');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('3', 'Necesidad de comparativo');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('4', 'En graficación');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('4', 'En análisis');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('4', 'Presentación preliminar');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('4', 'Presentación final');
INSERT INTO `ab1255_fabrica`.`prop_incumplimiento` (`id_area`, `des_incu`) VALUES ('4', 'Impresión / cds entregados / estudio finalizado');


ALTER TABLE `ab1255_fabrica`.`prop_calendario` 
ADD COLUMN `completado` TINYINT(1) NULL DEFAULT 0 AFTER `fecha_fin`,
ADD COLUMN `id_incu` INT NULL AFTER `completado`;


ALTER TABLE `ab1255_fabrica`.`prop_calendario` 
ADD INDEX `fk_prop_calendario_prop_incumplimiento_id_incu_idx` (`id_incu` ASC);
ALTER TABLE `ab1255_fabrica`.`prop_calendario` 
ADD CONSTRAINT `fk_prop_calendario_prop_incumplimiento_id_incu`
  FOREIGN KEY (`id_incu`)
  REFERENCES `ab1255_fabrica`.`prop_incumplimiento` (`id_incu`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

ALTER TABLE `ab1255_fabrica`.`prop_seg_metodologia_rta` 
ADD COLUMN `completado` INT NULL AFTER `id_area`;

ALTER TABLE `ab1255_fabrica`.`prop_seg_metodologia_rta` 
CHANGE COLUMN `completado` `completado` INT(11) NULL DEFAULT 0 ;

UPDATE prop_seg_metodologia_rta SET completado = 0;

ALTER TABLE `ab1255_fabrica`.`prop_inversion` 
ADD COLUMN `completado` INT NULL DEFAULT 0 AFTER `id_area`;


ALTER TABLE `ab1255_fabrica`.`prop_propuesta` 
ADD COLUMN `id_pob_objetivo` INT NULL COMMENT 'tipo_captura_brief' AFTER `fecha_inicio`,
ADD COLUMN `critica_codificacion` TINYINT(1) NULL DEFAULT 0 AFTER `id_pob_objetivo`,
ADD COLUMN `digitacion` TINYINT(1) NULL DEFAULT 0 AFTER `critica_codificacion`,
ADD COLUMN `entrega_tabulados` TINYINT(1) NULL DEFAULT 0 AFTER `digitacion`;

ALTER TABLE `ab1255_fabrica`.`prop_propuesta` 
DROP COLUMN `entrega_tabulados`;

ALTER TABLE `ab1255_fabrica`.`prop_propuesta` 
ADD COLUMN `entrega_tabulados` DATE NULL AFTER `digitacion`;

ALTER TABLE `ab1255_fabrica`.`prop_seg_metodologia_rta` 
ADD COLUMN `entregado` TINYINT(1) NULL DEFAULT 0 AFTER `completado`;

ALTER TABLE `ab1255_fabrica`.`prop_inversion` 
ADD COLUMN `entregado` TINYINT(1) NULL DEFAULT 0 AFTER `completado`;


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

##commit se registra la fecha de inicio de la propuesta
ALTER TABLE `ab1255_fabrica`.`prop_propuesta` 
ADD COLUMN `fecha_inicio` DATE NULL AFTER `fecha_creacion`;

UPDATE prop_propuesta SET fecha_inicio = fecha_creacion;

## commit registro fecha de inicio y fecha final por proceso de calendario
ALTER TABLE `ab1255_fabrica`.`prop_calendario` 
ADD COLUMN `fecha_ini` DATE NULL AFTER `id_area`,
ADD COLUMN `fecha_fin` DATE NULL AFTER `fecha_ini`;