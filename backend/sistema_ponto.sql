CREATE DATABASE IF NOT EXISTS `sistema_ponto`;
USE `sistema_ponto`;

CREATE TABLE IF NOT EXISTS `user` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 	`name` varchar(255) NOT NULL,
  	`email` varchar(255) NOT NULL UNIQUE,
  	`password` varchar(255) NOT NULL,
    `admin` ENUM('false', 'true') DEFAULT 'false',
	`enabled` ENUM('false', 'true') DEFAULT 'true'
);

CREATE TABLE IF NOT EXISTS `time_sheet` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 	`start` DATETIME NOT NULL,
  	`end` DATETIME NOT NULL UNIQUE,
    `user_id` int(11) NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
);

INSERT INTO `user` (`name`, `email`, `password`, `admin`, `enabled`) VALUES ('Administrador', 'administrador@sistemaponto.com', MD5('admin'), 'true', 'true');
INSERT INTO `user` (`name`, `email`, `password`, `admin`, `enabled`) VALUES ('Colaborador 1', 'colaborador1@sistemaponto.com', MD5('clbr1'), 'false', 'true');
INSERT INTO `user` (`name`, `email`, `password`, `admin`, `enabled`) VALUES ('Colaborador 2', 'colaborador2@sistemaponto.com', MD5('clbr2'), 'false', 'true');
INSERT INTO `user` (`name`, `email`, `password`, `admin`, `enabled`) VALUES ('Colaborador 3', 'colaborador3@sistemaponto.com', MD5('clbr3'), 'false', 'true');
