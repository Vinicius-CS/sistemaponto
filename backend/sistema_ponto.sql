CREATE DATABASE IF NOT EXISTS `sistema_ponto`;
USE `sistema_ponto`;

CREATE TABLE IF NOT EXISTS `user` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 	`name` varchar(255) NOT NULL,
  	`email` varchar(255) NOT NULL UNIQUE,
  	`password` varchar(255) NOT NULL,
    `admin` ENUM('false', 'true') DEFAULT 'false' NOT NULL,
	`enabled` ENUM('false', 'true') DEFAULT 'true' NOT NULL
);

CREATE TABLE IF NOT EXISTS `time_sheet` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 	`start` DATETIME NOT NULL,
  	`end` DATETIME UNIQUE DEFAULT NULL,
    `user_id` int(11) NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
);

INSERT INTO `user` (`name`, `email`, `password`, `admin`, `enabled`) VALUES ('Administrador', 'administrador@sistemaponto.com', MD5('admin'), 'true', 'true');
INSERT INTO `user` (`name`, `email`, `password`, `admin`, `enabled`) VALUES ('Colaborador 1', 'colaborador1@sistemaponto.com', MD5('123'), 'false', 'false');
INSERT INTO `user` (`name`, `email`, `password`, `admin`, `enabled`) VALUES ('Colaborador 2', 'colaborador2@sistemaponto.com', MD5('123'), 'true', 'false');
INSERT INTO `user` (`name`, `email`, `password`, `admin`, `enabled`) VALUES ('Colaborador 3', 'colaborador3@sistemaponto.com', MD5('123'), 'false', 'true');

INSERT INTO `time_sheet` (`start`, `end`, `user_id`) VALUES ('2022-09-20 08:00:00', '2022-09-20 18:30:00', '1');
INSERT INTO `time_sheet` (`start`, `end`, `user_id`) VALUES ('2022-09-20 08:30:00', '2022-09-20 18:00:00', '2');
INSERT INTO `time_sheet` (`start`, `end`, `user_id`) VALUES ('2022-09-20 08:35:00', '2022-09-20 18:05:00', '3');
INSERT INTO `time_sheet` (`start`, `end`, `user_id`) VALUES ('2022-09-20 08:40:00', '2022-09-20 18:10:00', '4');

INSERT INTO `time_sheet` (`start`, `end`, `user_id`) VALUES ('2022-09-21 08:00:00', '2022-09-21 18:30:00', '1');
INSERT INTO `time_sheet` (`start`, `end`, `user_id`) VALUES ('2022-09-21 08:40:00', '2022-09-21 18:05:00', '2');
INSERT INTO `time_sheet` (`start`, `end`, `user_id`) VALUES ('2022-09-21 08:30:00', '2022-09-21 18:10:00', '3');
INSERT INTO `time_sheet` (`start`, `end`, `user_id`) VALUES ('2022-09-21 08:35:00', '2022-09-21 18:15:00', '4');