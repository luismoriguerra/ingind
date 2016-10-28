
ALTER TABLE `procesos`.`personas`   
  ADD COLUMN `verified` TINYINT(1) DEFAULT 0 NOT NULL COMMENT 'indica si verifico su email' A
  ADD COLUMN `token` VARCHAR(255) NULL COMMENT 'TOken paRA ReRIFICAR email' AFTER `verified`;

ALTER TABLE `procesos`.`personas`   
  ADD COLUMN `celular` VARCHAR(50) NULL AFTER `email`,
  ADD COLUMN `telefono` VARCHAR(50) NULL AFTER `celular`,
  ADD COLUMN `direccion` VARCHAR(255) NULL AFTER `telefono`;


update  `procesos`.`personas`   set verified =1;