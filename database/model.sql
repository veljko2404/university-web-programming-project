DROP SCHEMA IF EXISTS `car_dealership` ;

CREATE SCHEMA IF NOT EXISTS `car_dealership` DEFAULT CHARACTER SET utf8 ;
USE `car_dealership` ;

CREATE TABLE IF NOT EXISTS `car_dealership`.`cars` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `make` VARCHAR(45) NOT NULL,
  `model` VARCHAR(45) NOT NULL,
  `year` INT NOT NULL,
  `price` INT NOT NULL,
  `number_of_available` INT NOT NULL,
  `image` VARCHAR(145) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `car_dealership`.`customers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(145) NOT NULL,
  `discount` INT NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `car_dealership`.`menagers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(145) NOT NULL,
  `sallary` VARCHAR(45) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `car_dealership`.`sellers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `work_from` DATE NOT NULL,
  `contract_duration_months` INT NOT NULL,
  `sallary` INT NOT NULL,
  `menager_id` INT NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`, `menager_id`),
  CONSTRAINT `fk_sellers_menagers1`
    FOREIGN KEY (`menager_id`)
    REFERENCES `car_dealership`.`menagers` (`id`))
ENGINE = InnoDB;