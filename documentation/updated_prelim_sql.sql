-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema stud_v17_arnesen
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema stud_v17_arnesen
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `stud_v17_arnesen` DEFAULT CHARACTER SET latin1 ;
USE `stud_v17_arnesen` ;

-- -----------------------------------------------------
-- Table `stud_v17_arnesen`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `stud_v17_arnesen`.`users` ;

CREATE TABLE IF NOT EXISTS `stud_v17_arnesen`.`users` (
  `email` VARCHAR(45) NOT NULL,
  `reg_date` DATETIME NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `role` INT(11) NOT NULL DEFAULT '1',
  `active` TINYINT(1) NOT NULL DEFAULT '0',
  `validated` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `stud_v17_arnesen`.`posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `stud_v17_arnesen`.`posts` ;

CREATE TABLE IF NOT EXISTS `stud_v17_arnesen`.`posts` (
  `post_id` INT(11) NOT NULL AUTO_INCREMENT,
  `post_title` VARCHAR(150) NOT NULL,
  `post_image_url` VARCHAR(256) NULL DEFAULT NULL,
  `post_date` DATETIME NOT NULL,
  `active` TINYINT(1) NOT NULL,
  `user_id` VARCHAR(45) NOT NULL,
  `times_visited` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  INDEX `fk_p_user_id_idx` (`user_id` ASC),
  CONSTRAINT `fk_p_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `stud_v17_arnesen`.`users` (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `stud_v17_arnesen`.`comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `stud_v17_arnesen`.`comments` ;

CREATE TABLE IF NOT EXISTS `stud_v17_arnesen`.`comments` (
  `comment_id` INT(11) NOT NULL AUTO_INCREMENT,
  `to_post` INT(11) NOT NULL,
  `to_comment` INT(11) NULL DEFAULT NULL,
  `made_by_user` VARCHAR(45) NOT NULL,
  `comment` VARCHAR(1000) NOT NULL,
  `active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`comment_id`),
  INDEX `fk_c_post_id_idx` (`to_post` ASC),
  INDEX `fk_c_user_id_idx` (`made_by_user` ASC),
  INDEX `fk_c_comment_id_idx` (`to_comment` ASC),
  CONSTRAINT `fk_c_comment_id`
    FOREIGN KEY (`to_comment`)
    REFERENCES `stud_v17_arnesen`.`comments` (`comment_id`),
  CONSTRAINT `fk_c_post_id`
    FOREIGN KEY (`to_post`)
    REFERENCES `stud_v17_arnesen`.`posts` (`post_id`),
  CONSTRAINT `fk_c_user_id`
    FOREIGN KEY (`made_by_user`)
    REFERENCES `stud_v17_arnesen`.`users` (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `stud_v17_arnesen`.`post_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `stud_v17_arnesen`.`post_details` ;

CREATE TABLE IF NOT EXISTS `stud_v17_arnesen`.`post_details` (
  `post_details_id` INT(11) NOT NULL AUTO_INCREMENT,
  `post_text` VARCHAR(4000) NOT NULL,
  `post_id` INT(11) NOT NULL,
  `post_sequence` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`post_details_id`),
  INDEX `fk_pd_post_id_idx` (`post_id` ASC),
  CONSTRAINT `fk_pd_post_id`
    FOREIGN KEY (`post_id`)
    REFERENCES `stud_v17_arnesen`.`posts` (`post_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `stud_v17_arnesen`.`sitesettings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `stud_v17_arnesen`.`sitesettings` ;

CREATE TABLE IF NOT EXISTS `stud_v17_arnesen`.`sitesettings` (
  `site_name` VARCHAR(45) NOT NULL,
  `site_title` VARCHAR(45) NOT NULL,
  `site_subtitle` VARCHAR(45) NOT NULL,
  `updated` DATETIME NOT NULL,
  `by_user` VARCHAR(45) NOT NULL,
  `site_mail` VARCHAR(45) NULL DEFAULT NULL,
  `site_activated` TINYINT(1) NOT NULL DEFAULT '0',
  INDEX `fk_user_id_idx` (`by_user` ASC),
  CONSTRAINT `fk_site_user_id`
    FOREIGN KEY (`by_user`)
    REFERENCES `stud_v17_arnesen`.`users` (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `stud_v17_arnesen`.`user_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `stud_v17_arnesen`.`user_details` ;

CREATE TABLE IF NOT EXISTS `stud_v17_arnesen`.`user_details` (
  `user_id` VARCHAR(45) NOT NULL,
  `firstname` VARCHAR(45) NULL DEFAULT NULL,
  `lastname` VARCHAR(45) NULL DEFAULT NULL,
  `user_name` VARCHAR(45) NULL DEFAULT NULL,
  `current_login` DATETIME NOT NULL,
  `last_login` DATETIME NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `stud_v17_arnesen`.`users` (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `stud_v17_arnesen`.`validation_link`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `stud_v17_arnesen`.`validation_link` ;

CREATE TABLE IF NOT EXISTS `stud_v17_arnesen`.`validation_link` (
  `validation_id` VARCHAR(50) NOT NULL,
  `user_id` VARCHAR(45) NOT NULL,
  `created` DATETIME NOT NULL,
  `used` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`validation_id`),
  UNIQUE INDEX `link_UNIQUE` (`validation_id` ASC),
  INDEX `fk_user_id_idx` (`user_id` ASC),
  CONSTRAINT `fk_val_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `stud_v17_arnesen`.`users` (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
