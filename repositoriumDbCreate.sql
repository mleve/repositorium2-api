SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `password` VARCHAR(70) NOT NULL,
  `created` DATE NOT NULL,
  `salt` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `criteria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `criteria` ;

CREATE TABLE IF NOT EXISTS `criteria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(145) NOT NULL,
  `upload_cost` INT NOT NULL,
  `download_cost` INT NOT NULL,
  `challenge_reward` INT NOT NULL,
  `created` DATE NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `experts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `experts` ;

CREATE TABLE IF NOT EXISTS `experts` (
  `user_id` VARCHAR(45) NULL,
  `criterion_id` INT NULL,
  INDEX `tag_owned_idx` (`criterion_id` ASC),
  INDEX `user_idx` (`user_id` ASC),
  CONSTRAINT `criteria_owned`
    FOREIGN KEY (`criterion_id`)
    REFERENCES `criteria` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `user_expert`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `apps`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `apps` ;

CREATE TABLE IF NOT EXISTS `apps` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT NOT NULL,
  `developer_id` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `dev_id_idx` (`developer_id` ASC),
  CONSTRAINT `dev_id`
    FOREIGN KEY (`developer_id`)
    REFERENCES `users` (`username`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `app_criteria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `app_criteria` ;

CREATE TABLE IF NOT EXISTS `app_criteria` (
  `app_id` INT NULL,
  `criterion_id` INT NULL,
  INDEX `tag_id_idx` (`criterion_id` ASC),
  INDEX `app_id_idx` (`app_id` ASC),
  CONSTRAINT `criteria_id`
    FOREIGN KEY (`criterion_id`)
    REFERENCES `criteria` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `app_id`
    FOREIGN KEY (`app_id`)
    REFERENCES `apps` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `documents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `documents` ;

CREATE TABLE IF NOT EXISTS `documents` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT NOT NULL,
  `creator_id` VARCHAR(45) NULL,
  `created` DATE NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `creator_idx` (`creator_id` ASC),
  CONSTRAINT `creator`
    FOREIGN KEY (`creator_id`)
    REFERENCES `users` (`username`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `files`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `files` ;

CREATE TABLE IF NOT EXISTS `files` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `document_id` INT NULL,
  `url` VARCHAR(70) NOT NULL,
  INDEX `document_id_idx` (`document_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `document_belongs`
    FOREIGN KEY (`document_id`)
    REFERENCES `documents` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `downloaded`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `downloaded` ;

CREATE TABLE IF NOT EXISTS `downloaded` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` VARCHAR(45) NULL,
  `document_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `document_id_idx` (`document_id` ASC),
  INDEX `user_idx` (`user_id` ASC),
  CONSTRAINT `document_downloaded`
    FOREIGN KEY (`document_id`)
    REFERENCES `documents` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `user_downloading`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `fullfill`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fullfill` ;

CREATE TABLE IF NOT EXISTS `fullfill` (
  `criterion_id` INT NULL,
  `document_id` INT NULL,
  `status` INT(1) NOT NULL,
  `positive` INT NULL,
  `negative` INT NULL,
  `created` DATE NOT NULL,
  `validated_date` DATE NULL,
  INDEX `tag_id_idx` (`criterion_id` ASC),
  INDEX `document_id_idx` (`document_id` ASC),
  CONSTRAINT `criteria_related`
    FOREIGN KEY (`criterion_id`)
    REFERENCES `criteria` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `document_satisfy`
    FOREIGN KEY (`document_id`)
    REFERENCES `documents` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `punctuations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `punctuations` ;

CREATE TABLE IF NOT EXISTS `punctuations` (
  `user_id` VARCHAR(45) NULL,
  `criterion_id` INT NULL,
  `score` INT NULL,
  `credit` INT NULL,
  `failure_rate` INT NULL,
  INDEX `document_id_idx` (`criterion_id` ASC),
  INDEX `user_idx` (`user_id` ASC),
  CONSTRAINT `criteria_puntuated`
    FOREIGN KEY (`criterion_id`)
    REFERENCES `criteria` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `user_punctuation`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`username`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
