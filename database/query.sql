ALTER TABLE `rutas_detalle`
ADD COLUMN `actividad`  varchar(255) NULL AFTER `ot_tiempo_transcurrido`;



ALTER TABLE `rutas_detalle`
ADD COLUMN `ot_tiempo_transcurrido`  int(9) NOT NULL AFTER `dtiempo_final`;




--08-12-2016 documentos digitales
ALTER TABLE `doc_digital`
ADD COLUMN `tipo_envio`  int(11) NULL DEFAULT 0 COMMENT '1:persona/2:gerencia' AFTER `persona_id`;

ALTER TABLE `doc_digital_area`
ADD COLUMN `rol_id`  int(11) NULL AFTER `area_id`;





CREATE TABLE `area_grupo` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(255) NULL ,
`nemonico`  varchar(50) NULL ,
`logo`  varchar(100) NULL ,
`estado`  tinyint(1) NULL DEFAULT 1 ,
`created_at`  datetime NULL DEFAULT CURRENT_TIMESTAMP ,
`updated_at`  datetime NULL ,
`usuario_created_at`  int(11) NULL ,
`usuario_updated_at`  int(11) NULL ,
PRIMARY KEY (`id`)
)
;

CREATE TABLE `area_grupo_integrante` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`area_grupo_id`  int(11) NOT NULL ,
`area_id`  int(11) NOT NULL ,
`estado`  tinyint(1) NOT NULL ,
`created_at`  datetime NULL DEFAULT CURRENT_TIMESTAMP ,
`updated_at`  datetime NULL ,
`usuario_created_at`  int(11) NOT NULL ,
`usuario_updated_at`  int(11) NOT NULL ,
PRIMARY KEY (`id`),
CONSTRAINT `fk_area_grupo` FOREIGN KEY (`area_grupo_id`) REFERENCES `area_grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `fk_areas_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
)
;



ALTER TABLE `doc_digital_area`
ADD COLUMN `tipo`  int(11) NOT NULL DEFAULT 1 COMMENT '1:original 2:copia' AFTER `area_id`;


ALTER TABLE `areas`
ADD COLUMN `nemonico_doc`  varchar(20) NULL AFTER `nemonico`;



CREATE TABLE `plantilla_doc` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`descripcion`  varchar(250) NULL ,
`tipo_documento_id`  int(10) NOT NULL ,
`area_id`  int(11) NOT NULL ,
`cuerpo`  text NOT NULL ,
`estado`  tinyint(1) NULL DEFAULT 1 ,
`created_at`  datetime NULL ,
`updated_at`  datetime NULL ,
`usuario_created_at`  int(11) NULL ,
`usuario_updated_at`  int(11) NULL ,
PRIMARY KEY (`id`),
CONSTRAINT `fk_documento` FOREIGN KEY (`tipo_documento_id`) REFERENCES `documentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `fk_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
)ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


CREATE TABLE `doc_digital` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`titulo`  varchar(250) NOT NULL ,
`asunto`  varchar(250) NOT NULL ,
`cuerpo`  text NOT NULL ,
`plantilla_doc_id`  int(11) NOT NULL ,
`persona_id`  int(11) NOT NULL COMMENT 'gerente actual que enviara el doc' ,
`created_at`  datetime NULL DEFAULT CURRENT_TIMESTAMP ,
`updated_at`  datetime NULL ,
`usuario_created_at`  int(11) NULL ,
`usuario_updated_at`  int(11) NULL ,
PRIMARY KEY (`id`),
CONSTRAINT `fk_plantilla` FOREIGN KEY (`plantilla_doc_id`) REFERENCES `plantilla_doc` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `fk_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
)
;

ALTER TABLE `doc_digital`
ADD COLUMN `area_id`  int(11) NOT NULL AFTER `plantilla_doc_id`;

ALTER TABLE `doc_digital` ADD CONSTRAINT `fk_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;



CREATE TABLE `doc_digital_area` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`doc_digital_id`  int(11) NOT NULL ,
`persona_id`  int(11) NOT NULL ,
`area_id`  int(11) NOT NULL ,
`estado`  tinyint(1) NOT NULL DEFAULT 1 ,
`created_at`  datetime NULL DEFAULT CURRENT_TIMESTAMP ,
`updated_at`  datetime NULL ,
`usuario_created_at`  int(11) NULL ,
`usuario_updated_at`  int(11) NULL ,
PRIMARY KEY (`id`),
CONSTRAINT `fk_doc_digital` FOREIGN KEY (`doc_digital_id`) REFERENCES `doc_digital` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `fk_persona_id` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `fk_area_id` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
)
;






--28-11-2016
ALTER TABLE `messages`
CHANGE COLUMN `user_id` `author_id`  int(11) NULL DEFAULT NULL COMMENT 'quien envia el mensaje' AFTER `conversation_id`,
ADD COLUMN `user_id`  int(11) NULL COMMENT 'quien recibe el mensaje' AFTER `author_id`;
ALTER TABLE `conversations`
ADD COLUMN `usuario_id`  int(11) NOT NULL COMMENT 'second in conversation' AFTER `author_id`;
ALTER TABLE `messages`
ADD COLUMN `read`  int(11) NULL AFTER `user_id`,
ADD COLUMN `fecha_leido`  date NULL AFTER `read`;
ALTER TABLE `messages`
CHANGE COLUMN `author_id` `user_id`  int(11) NULL DEFAULT NULL COMMENT 'quien envia el mensaje' AFTER `conversation_id`,
CHANGE COLUMN `user_id` `user_recept`  int(11) NULL DEFAULT NULL COMMENT 'quien recibe el mensaje' AFTER `user_id`,
MODIFY COLUMN `read`  tinyint(11) NULL DEFAULT NULL AFTER `user_recept`;







--11-11-2016
ALTER TABLE `procesos`.`personas`   
  ADD COLUMN `imagen_dni` VARCHAR(100) NULL AFTER `imagen`;

--08-11-2016

ALTER TABLE `procesos`.`empresa`   
  CHANGE `representante_legal` `persona_id` INT(11) NULL COMMENT 'persona_id';

RENAME TABLE `procesos`.`empresa` TO `procesos`.`empresas`;


ALTER TABLE `procesos`.`empresa_persona`   
  ADD COLUMN `representante_legal` INT(11) NULL COMMENT 'indica si es representante legal' AFTER `fecha_cese`;

--04-11-2016
DROP TABLE IF EXISTS `tipo_tramite` ;

CREATE  TABLE IF NOT EXISTS `tipo_tramite` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre_tipo_tramite` VARCHAR(100) NULL ,
  `estado` INT(11) NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT(11) NULL ,
  `usuario_updated_at` INT(11) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


DROP TABLE IF EXISTS `clasificador_tramite` ;

CREATE  TABLE IF NOT EXISTS `clasificador_tramite` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `area_id` INT(11) NOT NULL ,
  `tipo_tramite_id` INT NOT NULL ,
  `nombre_clasificador_tramite` VARCHAR(150) NULL ,
  `estado` INT(11) NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT(11) NULL ,
  `usuario_updated_at` INT(11) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_clasificador_tramite_areas1`
    FOREIGN KEY (`area_id` )
    REFERENCES `areas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clasificador_tramite_tipo_tramite1`
    FOREIGN KEY (`tipo_tramite_id` )
    REFERENCES `tipo_tramite` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_clasificador_tramite_areas1_idx` ON `clasificador_tramite` (`area_id` ASC) ;

CREATE INDEX `fk_clasificador_tramite_tipo_tramite1_idx` ON `clasificador_tramite` (`tipo_tramite_id` ASC) ;


-- -----------------------------------------------------
-- Table `empresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empresa` ;

CREATE  TABLE IF NOT EXISTS `empresa` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `tipo_id` INT NULL ,
  `ruc` INT(11) NULL ,
  `razon_social` VARCHAR(200) NULL ,
  `nombre_comercial` VARCHAR(150) NULL ,
  `direccion_fiscal` VARCHAR(250) NULL ,
  `representante_legal` INT NULL COMMENT 'persona_id' ,
  `cargo` VARCHAR(50) NULL ,
  `telefono` VARCHAR(12) NULL ,
  `fecha_vigencia` DATETIME NULL ,
  `estado` INT(11) NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT NULL ,
  `usuario_updated_at` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pretramites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pretramites` ;

CREATE  TABLE IF NOT EXISTS `pretramites` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `persona_id` INT(11) NOT NULL ,
  `clasificador_tramite_id` INT NOT NULL ,
  `empresa_id` INT(11) NULL ,
  `tipo_solicitante_id` INT NOT NULL ,
  `tipo_documento_id` INT NOT NULL ,
  `documento` VARCHAR(100) NULL ,
  `nro_folios` INT NULL ,
  `fecha_pretramite` DATETIME NULL ,
  `estado` INT(11) NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT(11) NULL ,
  `usuario_updated_at` INT(11) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_PRE TRAMITE_personas1`
    FOREIGN KEY (`persona_id` )
    REFERENCES `personas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRE_TRAMITE_clasificador_tramite1`
    FOREIGN KEY (`clasificador_tramite_id` )
    REFERENCES `clasificador_tramite` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRE_TRAMITE_empresa1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `empresa` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_PRE TRAMITE_personas1_idx` ON `pretramites` (`persona_id` ASC) ;

CREATE INDEX `fk_PRE_TRAMITE_clasificador_tramite1_idx` ON `pretramites` (`clasificador_tramite_id` ASC) ;

CREATE INDEX `fk_PRE_TRAMITE_empresa1_idx` ON `pretramites` (`empresa_id` ASC) ;


-- -----------------------------------------------------
-- Table `tipo_solicitante`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tipo_solicitante` ;

CREATE  TABLE IF NOT EXISTS `tipo_solicitante` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NULL DEFAULT NULL ,
  `nombre_relacion` VARCHAR(50) NULL DEFAULT NULL ,
  `estado` INT(11) NULL DEFAULT 1 ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `usuario_created_at` INT(11) NULL DEFAULT NULL ,
  `usuario_updated_at` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `tramites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tramites` ;

CREATE  TABLE IF NOT EXISTS `tramites` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pretramite_id` INT NOT NULL ,
  `persona_id` INT NOT NULL ,
  `clasificador_tramite_id` INT NOT NULL ,
  `empresa_id` INT NULL ,
  `tipo_solicitante_id` INT NOT NULL ,
  `tipo_documento_id` INT NOT NULL ,
  `documento` VARCHAR(100) NULL ,
  `nro_folios` INT NULL ,
  `fecha_tramite` DATETIME NULL ,
  `observacion` VARCHAR(250) NULL ,
  `imagen` VARCHAR(100) NULL ,
  `estado` INT(11) NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT(11) NULL ,
  `usuario_updated_at` INT(11) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_tramite_externo_clasificador_tramite1`
    FOREIGN KEY (`clasificador_tramite_id` )
    REFERENCES `clasificador_tramite` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tramite_externo_tipo_solicitante1`
    FOREIGN KEY (`tipo_solicitante_id` )
    REFERENCES `tipo_solicitante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tramite_pretramite1`
    FOREIGN KEY (`pretramite_id` )
    REFERENCES `pretramites` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tp_persona_id`
    FOREIGN KEY (`persona_id` )
    REFERENCES `personas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_empresa_id`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `empresa` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_tramite_externo_clasificador_tramite1_idx` ON `tramites` (`clasificador_tramite_id` ASC) ;

CREATE INDEX `fk_tramite_externo_tipo_solicitante1_idx` ON `tramites` (`tipo_solicitante_id` ASC) ;

CREATE INDEX `fk_tramite_pretramite1_idx` ON `tramites` (`pretramite_id` ASC) ;

CREATE INDEX `fk_tp_persona_id_idx` ON `tramites` (`persona_id` ASC) ;

CREATE INDEX `fk_empresa_id_idx` ON `tramites` (`empresa_id` ASC) ;


-- -----------------------------------------------------
-- Table `requisitos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `requisitos` ;

CREATE  TABLE IF NOT EXISTS `requisitos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `clasificador_tramite_id` INT NOT NULL ,
  `cantidad` INT(11) NULL ,
  `nombre` VARCHAR(100) NULL ,
  `estado` INT NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT(11) NULL ,
  `usuario_updated_at` INT(11) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_REQUISITOS_clasificador_tramite1`
    FOREIGN KEY (`clasificador_tramite_id` )
    REFERENCES `clasificador_tramite` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_REQUISITOS_clasificador_tramite1_idx` ON `requisitos` (`clasificador_tramite_id` ASC) ;


-- -----------------------------------------------------
-- Table `tramite_anexo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tramite_anexo` ;

CREATE  TABLE IF NOT EXISTS `tramites_anexo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tramite_id` INT NOT NULL ,
  `persona_id` INT NULL COMMENT 'Persona quien realiza el trámite del anexo' ,
  `fecha_anexo` DATETIME NULL ,
  `usuario_atendio` INT NULL COMMENT 'persona_id' ,
  `nombre` VARCHAR(100) NULL ,
  `nro_folios` INT NULL ,
  `obeservacion` VARCHAR(250) NULL ,
  `imagen` VARCHAR(100) NULL ,
  `estado` INT NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT(11) NULL ,
  `usuario_updated_at` INT(11) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_DetalleAnexo_tramite_externo1`
    FOREIGN KEY (`tramite_id` )
    REFERENCES `tramites` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_DetalleAnexo_tramite_externo1_idx` ON `tramite_anexo` (`tramite_id` ASC) ;


-- -----------------------------------------------------
-- Table `empresa_persona`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empresas_persona` ;

CREATE  TABLE IF NOT EXISTS `empresa_persona` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `empresa_id` INT(11) NOT NULL ,
  `persona_id` INT NULL COMMENT 'es la persona que podra realizar los tramites de la empresa seleccionada' ,
  `cargo` VARCHAR(100) NULL ,
  `fecha_vigencia` DATE NULL ,
  `fecha_cese` DATE NULL ,
  `estado` INT NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT NULL ,
  `usuario_updated_at` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_empresa_persona_empresa1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `empresa` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_empresa_persona_empresa1_idx` ON `empresa_persona` (`empresa_id` ASC) ;


-- -----------------------------------------------------
-- Table `tramites_requisitos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tramites_requisitos` ;

CREATE  TABLE IF NOT EXISTS `tramites_requisitos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tramite_id` INT NOT NULL ,
  `cantidad` INT(11) NULL ,
  `nombre` VARCHAR(100) NULL ,
  `estado` INT NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `usuario_created_at` INT(11) NULL ,
  `usuario_updated_at` INT(11) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_tramites_id`
    FOREIGN KEY (`tramite_id` )
    REFERENCES `tramites` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_tramites_id_idx` ON `tramites_requisitos` (`tramite_id` ASC) ;

/*******************************************************************************/
=======
--14/11/2016
ALTER TABLE `tramites_anexo`
ADD COLUMN `fecha_recepcion`  datetime NULL AFTER `fecha_anexo`;



--12-11-2016
ALTER TABLE `tramites`
ADD COLUMN `area_id`  int(11) NOT NULL AFTER `persona_id`;

ALTER TABLE `tramites` ADD CONSTRAINT `fk_tramite_area_id` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tramites`
MODIFY COLUMN `fecha_tramite`  datetime NULL DEFAULT CURRENT_TIMESTAMP AFTER `nro_folios`;




--08-11-2016
ALTER TABLE `pretramites`
MODIFY COLUMN `fecha_pretramite`  datetime NULL DEFAULT CURRENT_TIMESTAMP AFTER `nro_folios`;


CREATE TABLE `clasificador_tramite_area` (
`id`  int(11) NOT NULL ,
`clasificador_tramite_id`  int(11) NULL ,
`area_id`  int(11) NULL ,
`estado`  int(11) NULL DEFAULT 1 ,
`created_at`  datetime NULL ,
`updated_at`  datetime NULL ,
`usuario_created_at`  int(11) NULL ,
`usuario_updated_at`  int(11) NULL ,
PRIMARY KEY (`id`),
CONSTRAINT `fk_clasificador_tramite` FOREIGN KEY (`clasificador_tramite_id`) REFERENCES `clasificador_tramite` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
CONSTRAINT `fk_area_id` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION);

ALTER TABLE `clasificador_tramite_area`
MODIFY COLUMN `id`  int(11) NOT NULL AUTO_INCREMENT FIRST ;

ALTER TABLE `clasificador_tramite` DROP FOREIGN KEY `fk_clasificador_tramite_areas1`;
ALTER TABLE `clasificador_tramite`
DROP COLUMN `area_id`;


ALTER TABLE `pretramites`
ADD COLUMN `area_id`  int(11) NULL AFTER `clasificador_tramite_id`;
ALTER TABLE `pretramites` ADD CONSTRAINT `fk_PRE_TRAMITE_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE




--06-11-2016
ALTER TABLE `tipo_solicitante`
ADD COLUMN `pide_empresa`  int(11) NULL DEFAULT 0 AFTER `nombre_relacion`;




--27-10-2016
ALTER TABLE `rutas_detalle_verbo`
ADD COLUMN `adicional`  int NULL DEFAULT 0 AFTER `estado`;

--2016-10-20
ALTER TABLE `referidos`
CHANGE COLUMN `id_tipo` `ruta_detalle_verbo_id`  int(11) NULL DEFAULT NULL AFTER `tipo`;

ALTER TABLE `sustentos`
ADD COLUMN `ruta_detalle_verbo_id`  int(11) NULL AFTER `ruta_detalle_id`;

ALTER TABLE `rutas_detalle`
ADD COLUMN `motivo_edit`  varchar(255) NULL AFTER `observacion`;

--2016-09-23
ALTER TABLE `asignaciones`
MODIFY COLUMN `persona_id_i`  int(11) NULL DEFAULT 0 AFTER `idtipo`,
MODIFY COLUMN `persona_id_f`  int(11) NULL DEFAULT 0 AFTER `persona_id_i`;

CREATE TABLE `asignaciones` (
`id`  int NOT NULL AUTO_INCREMENT ,
`tipo`  int(1) NULL COMMENT '1:RutaDetalle-CartaDesglose | 2:RutaDetalleVerbo' ,
`idtipo`  int NULL ,
`persona_id_i`  int NULL ,
`persona_id_f`  int NULL ,
`estado`  int(1) NULL DEFAULT 1 ,
`usuario_created_at`  int NULL ,
`usuario_updated_at`  int NULL ,
`created_at`  datetime NULL ,
`updated_at`  datetime NULL ,
PRIMARY KEY (`id`)
)
;

ALTER TABLE `carta_desglose`
ADD COLUMN `cambios`  int NULL DEFAULT 0 COMMENT 'Cantidad de Cambios de los Responsables' AFTER `persona_id`;
--2016-09-15
CREATE TABLE `alertas` (
`id`  int NOT NULL AUTO_INCREMENT ,
`ruta_id`  int NULL ,
`ruta_detalle_id`  int NULL ,
`persona_id`  int NULL ,
`fecha`  date NULL ,
`estado`  int(1) NULL DEFAULT 1 ,
`usuario_created_at`  int NULL ,
`usuario_updated_at`  int NULL ,
`created_at`  datetime NULL ,
`updated_at`  datetime NULL ,
PRIMARY KEY (`id`)
)
;
-- passdo
ALTER TABLE `ingind`.`flujo_tipo_respuesta`   
  CHANGE `tiempo_id` `tiempo_id` INT(11) NULL,
  CHANGE `dtiempo` `dtiempo` INT(11) NULL  COMMENT 'Indica la cantida del tiempo segun su dimension',
  DROP FOREIGN KEY `flujo_tipo_respuesta_ibfk_2`;
