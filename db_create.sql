SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `password` VARCHAR(70) NOT NULL,
  `created` DATE NULL,
  `salt` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `criteria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `criteria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `upload_cost` INT NULL,
  `download_cost` INT NULL,
  `challenge_reward` INT NULL,
  `created` DATE NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `expert`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expert` (
  `user_id` VARCHAR(45) NULL,
  `criteria_id` INT NULL,
  INDEX `tag_owned_idx` (`criteria_id` ASC),
  INDEX `user_idx` (`user_id` ASC),
  CONSTRAINT `criteria_owned`
    FOREIGN KEY (`criteria_id`)
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
-- Table `app`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `app` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `description` TEXT NULL,
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
CREATE TABLE IF NOT EXISTS `app_criteria` (
  `app_id` INT NULL,
  `criteria_id` INT NULL,
  INDEX `tag_id_idx` (`criteria_id` ASC),
  INDEX `app_id_idx` (`app_id` ASC),
  CONSTRAINT `criteria_id`
    FOREIGN KEY (`criteria_id`)
    REFERENCES `criteria` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `app_id`
    FOREIGN KEY (`app_id`)
    REFERENCES `app` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `document`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `document` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` TEXT NULL,
  `creator_id` VARCHAR(45) NULL,
  `created` DATE NULL,
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
CREATE TABLE IF NOT EXISTS `files` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `document_id` INT NULL,
  `url` VARCHAR(45) NULL,
  INDEX `document_id_idx` (`document_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `document_belongs`
    FOREIGN KEY (`document_id`)
    REFERENCES `document` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `downloaded`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `downloaded` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` VARCHAR(45) NULL,
  `document_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `document_id_idx` (`document_id` ASC),
  INDEX `user_idx` (`user_id` ASC),
  CONSTRAINT `document_downloaded`
    FOREIGN KEY (`document_id`)
    REFERENCES `document` (`id`)
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
-- Table `fulfill`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fulfill` (
  `criteria_id` INT NULL,
  `document_id` INT NULL,
  `status` INT(1) NULL,
  `positive` INT NULL,
  `negative` INT NULL,
  `created` DATE NULL,
  `validated_date` DATE NULL,
  INDEX `tag_id_idx` (`criteria_id` ASC),
  INDEX `document_id_idx` (`document_id` ASC),
  CONSTRAINT `criteria_related`
    FOREIGN KEY (`criteria_id`)
    REFERENCES `criteria` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `document_satisfy`
    FOREIGN KEY (`document_id`)
    REFERENCES `document` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `punctuation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `punctuation` (
  `user_id` VARCHAR(45) NULL,
  `criteria_id` INT NULL,
  `score` INT NULL,
  `credit` INT NULL,
  `failure_rate` INT NULL,
  INDEX `document_id_idx` (`criteria_id` ASC),
  INDEX `user_idx` (`user_id` ASC),
  CONSTRAINT `criteria_puntuated`
    FOREIGN KEY (`criteria_id`)
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
