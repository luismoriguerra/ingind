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
