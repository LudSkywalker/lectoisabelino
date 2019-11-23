-- MySQL Script generated by MySQL Workbench
-- Tue Oct 29 19:26:06 2019
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
-- Table `lectoisabelino`.`categorialibro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`categorialibro` (
  `catLibId` INT(11) NOT NULL AUTO_INCREMENT,
  `catLibNombre` VARCHAR(60) NOT NULL,
  `catLibEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `catLibObservacion` VARCHAR(500) NULL DEFAULT NULL,
  PRIMARY KEY (`catLibId`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`libros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`libros` (
  `isbn` INT(5) NOT NULL DEFAULT 0,
  `titulo` VARCHAR(236) NULL DEFAULT NULL,
  `autor` VARCHAR(305) NULL DEFAULT NULL,
  `precio` VARCHAR(10) NULL DEFAULT NULL,
  `estado` TINYINT(1) NOT NULL DEFAULT 1,
  `categoriaLibro_catLibId` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`isbn`, `categoriaLibro_catLibId`),
  CONSTRAINT `fk_libros_categoriaLibro1`
    FOREIGN KEY (`categoriaLibro_catLibId`)
    REFERENCES `lectoisabelino`.`categorialibro` (`catLibId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_libros_categoriaLibro1_idx` ON `lectoisabelino`.`libros` (`categoriaLibro_catLibId` ASC) INVISIBLE;


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
  PRIMARY KEY (`usuId`))
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE UNIQUE INDEX `uniq_login` ON `lectoisabelino`.`usuario_s` (`usuLogin` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`persona`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`persona` (
  `perId` INT(11) NOT NULL COMMENT 'Nos muetsra el Id de la tabla persona',
  `perDocumento` VARCHAR(20) NOT NULL COMMENT 'Nos muestra el documento de la persona',
  `perNombre` VARCHAR(100) NOT NULL COMMENT 'Nos muestra el nombre de la persona',
  `perApellido` VARCHAR(255) NOT NULL COMMENT 'Nos muestra el apellido de la persona',
  `perEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `perUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `per_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `per_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `usuario_s_usuId` INT(11) NOT NULL,
  PRIMARY KEY (`perId`, `usuario_s_usuId`),
  CONSTRAINT `fk_persona_usuario_s1`
    FOREIGN KEY (`usuario_s_usuId`)
    REFERENCES `lectoisabelino`.`usuario_s` (`usuId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Esta tabla nos muestra los datos de la persona ';

CREATE UNIQUE INDEX `uniq_documento` ON `lectoisabelino`.`persona` (`perDocumento` ASC) VISIBLE;

CREATE INDEX `fk_persona_usuario_s1_idx` ON `lectoisabelino`.`persona` (`usuario_s_usuId` ASC) VISIBLE;


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
  PRIMARY KEY (`rolId`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE UNIQUE INDEX `uniq_nombrerol` ON `lectoisabelino`.`rol` (`rolNombre` ASC) VISIBLE;


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
  CONSTRAINT `usuario_s_roles_fk_rolidrol`
    FOREIGN KEY (`id_rol`)
    REFERENCES `lectoisabelino`.`rol` (`rolId`),
  CONSTRAINT `usuario_s_roles_fk_usuario_sid`
    FOREIGN KEY (`id_usuario_s`)
    REFERENCES `lectoisabelino`.`usuario_s` (`usuId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE INDEX `usuario_s_roles_fk_rolidrol` ON `lectoisabelino`.`usuario_s_roles` (`id_rol` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`categoria_libro_lecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`categoria_libro_lecto` (
  `catLecId` INT NOT NULL AUTO_INCREMENT,
  `catLecNombre` VARCHAR(60) NOT NULL,
  `catLecEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `catLecObsSalida` TEXT NULL DEFAULT NULL,
  `catLecObsEntrada` TEXT NULL DEFAULT NULL,
  `catLecUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `catLec_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `catLec_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP (),
  PRIMARY KEY (`catLecId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`categoria_elementos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`categoria_elementos` (
  `catEleId` INT NOT NULL DEFAULT 1,
  `catEleNombre` VARCHAR(60) NOT NULL,
  `catEleEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `catEleObsEntrada` TEXT NULL DEFAULT NULL,
  `catEleObsSalida` TEXT NULL DEFAULT NULL,
  `catEleUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `catEle_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `catEle_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`catEleId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`estado_libros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`estado_libros` (
  `estLibId` INT NOT NULL AUTO_INCREMENT,
  `estLibNombre` VARCHAR(236) NOT NULL,
  `estLibObs` TEXT NULL,
  `estLibEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `estLibUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `estLib_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `estLib_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`estLibId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`libros_lecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`libros_lecto` (
  `libLecId` INT NOT NULL AUTO_INCREMENT,
  `libLecCodigo` VARCHAR(20) NOT NULL,
  `libLecTitulo` VARCHAR(236) NOT NULL,
  `libLecAutor` VARCHAR(236) NULL,
  `libLecEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `libLecUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `libLec_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `libLec_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `categoria_libro_lecto_catLecId` INT(11) NOT NULL,
  `estado_libros_estLibId` INT(11) NOT NULL,
  PRIMARY KEY (`libLecId`, `categoria_libro_lecto_catLecId`, `estado_libros_estLibId`),
  CONSTRAINT `fk_libros_lecto_categoria_libro_lecto1`
    FOREIGN KEY (`categoria_libro_lecto_catLecId`)
    REFERENCES `lectoisabelino`.`categoria_libro_lecto` (`catLecId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_libros_lecto_estado_libros1`
    FOREIGN KEY (`estado_libros_estLibId`)
    REFERENCES `lectoisabelino`.`estado_libros` (`estLibId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_libros_lecto_categoria_libro_lecto1_idx` ON `lectoisabelino`.`libros_lecto` (`categoria_libro_lecto_catLecId` ASC) VISIBLE;

CREATE INDEX `fk_libros_lecto_estado_libros1_idx` ON `lectoisabelino`.`libros_lecto` (`estado_libros_estLibId` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`contr_prestamos_libros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`contr_prestamos_libros` (
  `conPId` INT NOT NULL DEFAULT 1,
  `conPFecha` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `conPPrestado` TINYINT NULL DEFAULT 0,
  `conPObsSalida` TEXT NULL DEFAULT NULL,
  `conPObsEntrada` TEXT NULL DEFAULT NULL,
  `conPUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `conP_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `conP_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `conPEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `persona_perId` INT(11) NOT NULL,
  `libros_lecto_libLecId` INT NOT NULL,
  PRIMARY KEY (`conPId`, `persona_perId`, `libros_lecto_libLecId`),
  CONSTRAINT `fk_contr_prestamos_libros_persona1`
    FOREIGN KEY (`persona_perId`)
    REFERENCES `lectoisabelino`.`persona` (`perId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contr_prestamos_libros_libros_lecto1`
    FOREIGN KEY (`libros_lecto_libLecId`)
    REFERENCES `lectoisabelino`.`libros_lecto` (`libLecId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_contr_prestamos_libros_persona1_idx` ON `lectoisabelino`.`contr_prestamos_libros` (`persona_perId` ASC) VISIBLE;

CREATE INDEX `fk_contr_prestamos_libros_libros_lecto1_idx` ON `lectoisabelino`.`contr_prestamos_libros` (`libros_lecto_libLecId` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`estado_elementos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`estado_elementos` (
  `estEleId` INT NOT NULL DEFAULT 1,
  `estEleNombre` VARCHAR(236) NOT NULL,
  `estEleObs` TEXT NULL DEFAULT NULL,
  `estEleEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `estEleUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `estEle_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `estEle_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`estEleId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`elementos_lecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`elementos_lecto` (
  `eleLecId` INT NOT NULL DEFAULT 1,
  `eleLecCodigo` VARCHAR(20) NOT NULL,
  `eleLecTitulo` VARCHAR(236) NOT NULL,
  `eleLecAutor` VARCHAR(236) NULL DEFAULT NULL,
  `eleLecEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `eleLecUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `eleLec_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `eleLec_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `estado_elementos_estEleId` INT NOT NULL,
  `categoria_elementos_catEleId` INT NOT NULL,
  PRIMARY KEY (`eleLecId`, `estado_elementos_estEleId`, `categoria_elementos_catEleId`),
  CONSTRAINT `fk_elementos_lecto_estado_elementos1`
    FOREIGN KEY (`estado_elementos_estEleId`)
    REFERENCES `lectoisabelino`.`estado_elementos` (`estEleId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_elementos_lecto_categoria_elementos1`
    FOREIGN KEY (`categoria_elementos_catEleId`)
    REFERENCES `lectoisabelino`.`categoria_elementos` (`catEleId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_elementos_lecto_estado_elementos1_idx` ON `lectoisabelino`.`elementos_lecto` (`estado_elementos_estEleId` ASC) VISIBLE;

CREATE INDEX `fk_elementos_lecto_categoria_elementos1_idx` ON `lectoisabelino`.`elementos_lecto` (`categoria_elementos_catEleId` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `lectoisabelino`.`contr_elementos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lectoisabelino`.`contr_elementos` (
  `conEId` INT NOT NULL DEFAULT 1,
  `conEFecha` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `conEPrestado` TINYINT NULL DEFAULT 0,
  `conEObsSalida` TEXT NULL DEFAULT NULL,
  `conEObsEntrada` TEXT NULL DEFAULT NULL,
  `conEUsuSesion` VARCHAR(20) NULL DEFAULT NULL,
  `conE_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `conE_updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `conEEstado` TINYINT(1) NOT NULL DEFAULT 1,
  `persona_perId` INT(11) NOT NULL,
  `elementos_lecto_eleLecId` INT NOT NULL,
  PRIMARY KEY (`conEId`, `persona_perId`, `elementos_lecto_eleLecId`),
  CONSTRAINT `fk_contr_elementos_persona1`
    FOREIGN KEY (`persona_perId`)
    REFERENCES `lectoisabelino`.`persona` (`perId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contr_elementos_elementos_lecto1`
    FOREIGN KEY (`elementos_lecto_eleLecId`)
    REFERENCES `lectoisabelino`.`elementos_lecto` (`eleLecId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_contr_elementos_persona1_idx` ON `lectoisabelino`.`contr_elementos` (`persona_perId` ASC) VISIBLE;

CREATE INDEX `fk_contr_elementos_elementos_lecto1_idx` ON `lectoisabelino`.`contr_elementos` (`elementos_lecto_eleLecId` ASC) VISIBLE;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
