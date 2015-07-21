CREATE TABLE `tipo_visualizacion`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50),
  `estado` INT,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  `usuario_created_at` INT,
  `usuario_updated_at` INT,
  PRIMARY KEY (`id`)
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE `visualizacion_tramite`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ruta_detalle_id` INT NULL,
  `tipo_visualizacion_id` INT,
  `estado` INT NULL,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  `usuario_created_at` INT,
  `usuario_updated_at` INT,
  PRIMARY KEY (`id`)
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_general_ci;
