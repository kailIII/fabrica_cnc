#Ajuste tarifario
UPDATE prop_metodologia SET a_tam_poblacion = 0 WHERE id_subnivel = 1;
INSERT INTO `ab1255_fabrica`.`prop_nivel_aceptacion` (`des_nivel_aceptacion`, `min`, `max`) VALUES ('No aplica', '0', '0');


###
DELETE FROM `ab1255_fabrica`.`empleado` WHERE `id_empleado`='jmazorco';
#orden de duracion
ALTER TABLE `ab1255_fabrica`.`prop_duracion`
ADD COLUMN `orden` TINYINT(1) NULL AFTER `activo`;

UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='0' WHERE `id_duracion`='1';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='1' WHERE `id_duracion`='2';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='2' WHERE `id_duracion`='3';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='3' WHERE `id_duracion`='4';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='4' WHERE `id_duracion`='5';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='8' WHERE `id_duracion`='6';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='9' WHERE `id_duracion`='7';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='5' WHERE `id_duracion`='13';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='6' WHERE `id_duracion`='10';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='10' WHERE `id_duracion`='9';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='7' WHERE `id_duracion`='12';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='11' WHERE `id_duracion`='11';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='12' WHERE `id_duracion`='14';
UPDATE `ab1255_fabrica`.`prop_duracion` SET `orden`='13' WHERE `id_duracion`='8';

#### ajustes tarifario

DELETE FROM `ab1255_fabrica`.`prop_cobertura` WHERE `id_cobertura`='1';
DELETE FROM `ab1255_fabrica`.`prop_cobertura` WHERE `id_cobertura`='5';

INSERT INTO `ab1255_fabrica`.`prop_metodologia` (`id_metodologia`, `nom_metodologia`, `estado`, `id_tipo_metodologia`, `des_metodologia`, `r_reunion`, `r_entrega_material`, `r_elab_instrumento`, `r_aprob_instrumento`, `r_aprob_analisis`, `r_recoleccion_info`, `r_procesamiento`, `r_analisis`, `r_resultados`, `t_reunion`, `t_entrega_material`, `t_elab_instrumento`, `t_aprob_instrumento`, `t_recoleccion_info`, `t_procesamiento`, `t_resultados`, `e_guias_formularios`, `e_grabaciones`, `e_db`, `e_tabulados`, `e_informe`, `e_presentacion`, `is_presencial`, `a_tecnica_recoleccion`, `a_marco_muestral`, `a_duracion`, `a_dificultad`, `titulo_tecnica_recoleccion`, `titulo_marco_muestral`, `titulo_duracion`, `titulo_dificultad`, `titulo_universo`, `titulo_tam_poblacion`, `a_incidencia`, `a_tam_poblacion`, `ids_pob_objetivo`, `ids_cobertura`, `id_subnivel`, `exclude_tipo_cuant`) VALUES ('19', 'Auditoría', '1', '2', 'Las etnografías sirven para estudiar los comportamientos del consumidor mediante una observación en el sitio que permite ubicar lo que ocurre con la vida cotidiana con los productos o servicios a partir de cinco dimensiones: las personas, las familias, las acciones, los lugares y los objetos. Esta información es de una inmensa utilidad para ir más allá de las palabras y comprender las acciones en el contexto en que se dan.', 'CNC-Entidad Cliente', 'Entidad Cliente', 'CNC-Entidad Cliente', 'CNC-Entidad Cliente', 'CNC-Entidad Cliente', 'CNC', '', 'CNC', 'CNC', '1', '1', '1', '1', '2', '2', '1', '', '', '', '', '', '', '1', '1', '1', '1', '1', 'Tamaño del grupo', 'Método de captación de los participantes', 'Periodo de tiempo', 'Dificultad', 'Perfil del informante', 'Tamaño de la población', '1', '1', '21', '2,1,5', '2', '');


## update titulos metodologias

UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Café conversación ' WHERE `id_metodologia`='1';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Grupo focal' WHERE `id_metodologia`='2';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Historia de vida' WHERE `id_metodologia`='3';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Etnografía' WHERE `id_metodologia`='4';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Entrevista en profundidad' WHERE `id_metodologia`='5';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Procesos en U' WHERE `id_metodologia`='8';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Tormenta de ideas' WHERE `id_metodologia`='9';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Colgada en página web' WHERE `id_metodologia`='10';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Direct mailing o correo directo' WHERE `id_metodologia`='11';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Entrevista cita previa en empresa' WHERE `id_metodologia`='12';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Entrevista presencial en hogar' WHERE `id_metodologia`='13';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Locación central' WHERE `id_metodologia`='14';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Solo preguntas cerradas' WHERE `id_metodologia`='15';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Telefónica en hogar' WHERE `id_metodologia`='16';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Telefónico empresa' WHERE `id_metodologia`='17';
UPDATE `ab1255_fabrica`.`prop_metodologia` SET `nom_metodologia`='Reunión' WHERE `id_metodologia`='18';

## brief 2
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