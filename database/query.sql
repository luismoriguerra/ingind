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
