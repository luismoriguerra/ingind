ALTER TABLE `ingind`.`flujo_tipo_respuesta`   
  CHANGE `tiempo_id` `tiempo_id` INT(11) NULL,
  CHANGE `dtiempo` `dtiempo` INT(11) NULL  COMMENT 'Indica la cantida del tiempo segun su dimension',
  DROP FOREIGN KEY `flujo_tipo_respuesta_ibfk_2`;