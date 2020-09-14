DROP DATABASE IF EXISTS `MessageBoard`;
CREATE DATABASE IF NOT EXISTS `MessageBoard` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `MessageBoard`;

DROP TABLE IF EXISTS `Members`;
CREATE TABLE `Members`(
    `userID` INT NOT NULL AUTO_INCREMENT,
    `userAccount` VARCHAR(20) NOT NULL,
    `userPassword` TEXT NOT NULL,
    `userName` VARCHAR(20) NOT NULL,
    `userEmail` VARCHAR(50) NOT NULL,
    `userPhone` VARCHAR(20) NOT NULL,
    `creationDate` datetime NOT NULL,
    `changeDate` datetime NOT NULL,
    PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `Boards`;
CREATE TABLE `Boards` (
    `boardID` int NOT NULL AUTO_INCREMENT,
    `userID` INT NOT NULL,
    `creationDate` datetime NOT NULL,
    `changeDate` datetime NOT NULL,
    `authority` int NOT NULL,
    PRIMARY KEY (`boardID`),
    FOREIGN KEY (`userID`) REFERENCES `Members`(`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `Messages`;
CREATE TABLE `Messages` (
    `messageID` int NOT NULL AUTO_INCREMENT,
    `boardID` int NOT NULL,
    `userID` INT NOT NULL,
    `creationDate` datetime NOT NULL,
    `message` TEXT NOT NULL,
    PRIMARY KEY (`messageID`),
    FOREIGN KEY (`userID`) REFERENCES `Members`(`userID`),
    FOREIGN KEY (`boardID`) REFERENCES `Boards`(`boardID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `OldMessage`;
CREATE TABLE `OldMessage` (
    `messageID` int NOT NULL,
    `creationDate` datetime NOT NULL,
    `message` TEXT NOT NULL,
    PRIMARY KEY (`messageID`,`creationDate`),
    FOREIGN KEY (`messageID`) REFERENCES `Messages`(`messageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `Friends`;
CREATE TABLE `Friends` (
    `userID` INT NOT NULL,
    `friendID` INT NOT NULL,
    `creationDate` datetime NOT NULL,
    PRIMARY KEY (`userID`,`friendID`),
    FOREIGN KEY (`userID`) REFERENCES `Members`(`userID`),
    FOREIGN KEY (`friendID`) REFERENCES `Members`(`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Members`(`userAccount`, `userPassword`, `userName`, `userEmail`, `userPhone`, `creationDate`, `changeDate`) VALUES 
('a01','123456','aa','aa@aa.aa','123456',NOW(),NOW()),
('a02','123456','aa','aa@aa.aa','123456',NOW(),NOW()),
('a03','123456','aa','aa@aa.aa','123456',NOW(),NOW());

INSERT INTO `Boards`(`userID`, `creationDate`, `changeDate`, `authority`) VALUES
(1,NOW(),NOW(),0),
(1,NOW(),NOW(),0),
(1,NOW(),NOW(),0);