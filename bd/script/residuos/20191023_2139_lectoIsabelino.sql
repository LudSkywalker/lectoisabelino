-- MySQL Script generated by MySQL Workbench
-- Wed Oct 23 21:40:56 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema lectoisabelino
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema lectoisabelino
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `lectoisabelino` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `lectoisabelino` ;
-- -----------------------------------------------------
-- Table `lectoisabelino`.`libros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`libros` (
  `libIsbn` INT(5) NOT NULL DEFAULT 0,
  `libTitulo` VARCHAR(236) NULL DEFAULT NULL,
  `libAutor` VARCHAR(305) NULL DEFAULT NULL,
  `libPrecio` VARCHAR(10) NULL DEFAULT NULL,
  `libEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `libUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `lib_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `lib_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `categoriaLibro_catLibId` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`libIsbn`, `categoriaLibro_catLibId`),
  INDEX `fk_libros_categoriaLibro1_idx` (`categoriaLibro_catLibId` ASC) VISIBLE,
  CONSTRAINT `fk_libros_categoriaLibro1`
    FOREIGN KEY (`categoriaLibro_catLibId`)
    REFERENCES `lectoisabelino`.`categorialibro` (`catLibId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`categorialibro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`categorialibro` (
  `catLibId` INT(11) NOT NULL AUTO_INCREMENT,
  `catLibNombre` VARCHAR(60) NOT NULL,
  `catLibEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `catLibObservacion` VARCHAR(500) NULL DEFAULT NULL,
  `catLibUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `catLib_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `catLib_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`catLibId`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`libros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`libros` (
  `libIsbn` INT(5) NOT NULL DEFAULT 0,
  `libTitulo` VARCHAR(236) NULL DEFAULT NULL,
  `libAutor` VARCHAR(305) NULL DEFAULT NULL,
  `libPrecio` VARCHAR(10) NULL DEFAULT NULL,
  `libEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `libUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `lib_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `lib_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `categoriaLibro_catLibId` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`libIsbn`, `categoriaLibro_catLibId`),
  INDEX `fk_libros_categoriaLibro1_idx` (`categoriaLibro_catLibId` ASC) VISIBLE,
  CONSTRAINT `fk_libros_categoriaLibro1`
    FOREIGN KEY (`categoriaLibro_catLibId`)
    REFERENCES `lectoisabelino`.`categorialibro` (`catLibId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`usuario_s`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`usuario_s` (
  `usuId` INT(11) NOT NULL AUTO_INCREMENT,
  `usuLogin` VARCHAR(50) NOT NULL,
  `usuPassword` VARCHAR(100) NOT NULL,
  `usuUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `usuEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `usuRemember_token` VARCHAR(100) NOT NULL,
  `usu_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `usu_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`usuId`),
  UNIQUE INDEX `uniq_login` (`usuLogin` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`persona`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`persona` (
  `usuario_s_usuId` INT(11) NOT NULL COMMENT 'Nos muetsra el Id de la tabla persona',
  `perDocumento` VARCHAR(20) NOT NULL COMMENT 'Nos muestra el documento de la persona',
  `perNombre` VARCHAR(100) NOT NULL COMMENT 'Nos muestra el nombre de la persona',
  `perApellido` VARCHAR(255) NOT NULL COMMENT 'Nos muestra el apellido de la persona',
  `perEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `perUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `per_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `per_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `usuario_s_usuId` INT(11) NOT NULL,
  PRIMARY KEY (`usuario_s_usuId`, `usuario_s_usuId`),
  UNIQUE INDEX `uniq_documento` (`perDocumento` ASC) VISIBLE,
  INDEX `fk_persona_usuario_s1_idx` (`usuario_s_usuId` ASC) VISIBLE,
  CONSTRAINT `fk_persona_usuario_s1`
    FOREIGN KEY (`usuario_s_usuId`)
    REFERENCES `lectoisabelino`.`usuario_s` (`usuId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Esta tabla nos muestra los datos de la persona ';


-- -----------------------------------------------------
-- Table `lectoisabelino`.`rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`rol` (
  `rolId` INT(11) NOT NULL AUTO_INCREMENT,
  `rolNombre` VARCHAR(32) NOT NULL,
  `rolDescripcion` VARCHAR(255) NOT NULL,
  `rolEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `rolUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `rol_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `rol_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`rolId`),
  UNIQUE INDEX `uniq_nombrerol` (`rolNombre` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`usuario_s_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`usuario_s_roles` (
  `id_usuario_s` INT(11) NOT NULL,
  `id_rol` INT(11) NOT NULL,
  `estado` TINYINT(1) NOT NULL DEFAULT 1,
  `fechaUserRol` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `obsFechaUserRol` TEXT NULL DEFAULT NULL,
  `usuRolUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id_usuario_s`, `id_rol`),
  INDEX `usuario_s_roles_fk_rolidrol` (`id_rol` ASC) VISIBLE,
  CONSTRAINT `usuario_s_roles_fk_rolidrol`
    FOREIGN KEY (`id_rol`)
    REFERENCES `lectoisabelino`.`rol` (`rolId`),
  CONSTRAINT `usuario_s_roles_fk_usuario_sid`
    FOREIGN KEY (`id_usuario_s`)
    REFERENCES `lectoisabelino`.`usuario_s` (`usuId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`categoriaelementos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`categoriaelementos` (
  `catEleId` INT(11) NOT NULL,
  `catEleNombre` VARCHAR(60) NOT NULL,
  `catEleEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `catEleObservacion` VARCHAR(500) NULL DEFAULT NULL,
  `catEleUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `catEle_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `catEle_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`catEleId`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`elementos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`elementos` (
  `eleId` INT(5) NOT NULL DEFAULT 0,
  `eleObjeto` VARCHAR(236) NULL DEFAULT NULL,
  `eleEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `eleUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `ele_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `ele_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `categoriaelementos_catEleId` INT(11) NOT NULL,
  PRIMARY KEY (`eleId`, `categoriaelementos_catEleId`),
  INDEX `fk_elementos_categoriaelementos1_idx` (`categoriaelementos_catEleId` ASC) VISIBLE,
  CONSTRAINT `fk_elementos_categoriaelementos1`
    FOREIGN KEY (`categoriaelementos_catEleId`)
    REFERENCES `lectoisabelino`.`categoriaelementos` (`catEleId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`contrPrestamos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`contrPrestamos` (
  `conPId` INT NOT NULL AUTO_INCREMENT,
  `conPFecha` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `conPPrestado` TINYINT NULL DEFAULT 0,
  `conPObsSalida` TEXT NULL DEFAULT NULL,
  `conPObsEntrada` TEXT NULL DEFAULT NULL,
  `persona_usuario_s_usuId` INT(11) NOT NULL,
  `persona_usuario_s_usuId` INT(11) NOT NULL,
  `libros_libIsbn` INT(5) NOT NULL,
  `libros_categoriaLibro_catLibId` INT(11) NOT NULL,
  PRIMARY KEY (`conPId`, `persona_usuario_s_usuId`, `persona_usuario_s_usuId`, `libros_libIsbn`, `libros_categoriaLibro_catLibId`),
  INDEX `fk_contrPrestamos_persona1_idx` (`persona_usuario_s_usuId` ASC, `persona_usuario_s_usuId` ASC) VISIBLE,
  INDEX `fk_contrPrestamos_libros1_idx` (`libros_libIsbn` ASC, `libros_categoriaLibro_catLibId` ASC) VISIBLE,
  CONSTRAINT `fk_contrPrestamos_persona1`
    FOREIGN KEY (`persona_usuario_s_usuId` , `persona_usuario_s_usuId`)
    REFERENCES `lectoisabelino`.`persona` (`usuario_s_usuId` , `usuario_s_usuId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrPrestamos_libros1`
    FOREIGN KEY (`libros_libIsbn` , `libros_categoriaLibro_catLibId`)
    REFERENCES `lectoisabelino`.`libros` (`libIsbn` , `categoriaLibro_catLibId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`contrElementos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`contrElementos` (
  `conEId` INT NOT NULL AUTO_INCREMENT,
  `conEFecha` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `conEPrestado` TINYINT NULL DEFAULT 0,
  `conEObsSalida` TEXT NULL DEFAULT NULL,
  `conEObsEntrada` TEXT NULL DEFAULT NULL,
  `persona_usuario_s_usuId` INT(11) NOT NULL,
  `persona_usuario_s_usuId` INT(11) NOT NULL,
  `elementos_eleId` INT(5) NOT NULL,
  `elementos_categoriaelementos_catEleId` INT(11) NOT NULL,
  PRIMARY KEY (`conEId`, `persona_usuario_s_usuId`, `persona_usuario_s_usuId`, `elementos_eleId`, `elementos_categoriaelementos_catEleId`),
  INDEX `fk_contrElementos_persona1_idx` (`persona_usuario_s_usuId` ASC, `persona_usuario_s_usuId` ASC) VISIBLE,
  INDEX `fk_contrElementos_elementos1_idx` (`elementos_eleId` ASC, `elementos_categoriaelementos_catEleId` ASC) VISIBLE,
  CONSTRAINT `fk_contrElementos_persona1`
    FOREIGN KEY (`persona_usuario_s_usuId` , `persona_usuario_s_usuId`)
    REFERENCES `lectoisabelino`.`persona` (`usuario_s_usuId` , `usuario_s_usuId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrElementos_elementos1`
    FOREIGN KEY (`elementos_eleId` , `elementos_categoriaelementos_catEleId`)
    REFERENCES `lectoisabelino`.`elementos` (`eleId` , `categoriaelementos_catEleId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
