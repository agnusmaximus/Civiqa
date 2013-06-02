DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
       `UserID` BIGINT UNSIGNED NOT NULL,
       `FirstName` VARCHAR(25) NOT NULL,
       `LastName` VARCHAR(35) NOT NULL,
       `Email` VARCHAR(60) NOT NULL,
       `Gender` VARCHAR(8) NOT NULL,
       `Location` VARCHAR(15),
    	`Picture` VARCHAR(256) NOT NULL,
    	`LargePicture` VARCHAR(256) NOT NULL,
        
	FULLTEXT KEY `FirstName` (`FirstName`),
	FULLTEXT KEY `LastName` (`LastName`),
	KEY `UserID` (`UserID`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Opposition`;

CREATE TABLE `Opposition` (
	`OpposerID` BIGINT UNSIGNED NOT NULL,
	`OpposedID` BIGINT UNSIGNED NOT NULL,
	
	UNIQUE KEY `OpposerID` (`OpposerID`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Associates`;

CREATE TABLE `Associates` (
       `UserID` BIGINT UNSIGNED NOT NULL,
       `AssociateID` BIGINT UNSIGNED NOT NULL,

       KEY `UserID` (`UserID`),
       KEY `AssociateID` (`AssociateID`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Movement`;

CREATE TABLE `Movement` (
       `MovementID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
       `CreatorID` BIGINT UNSIGNED NOT NULL,
       `Title` VARCHAR(128) NOT NULL,
       `Text` VARCHAR(512),
       `PowerIndex` BIGINT UNSIGNED NOT NULL,
       `Date` DATETIME NOT NULL,
       `NumSupporters` BIGINT UNSIGNED NOT NULL,
       `SupporterGain` BIGInt UNSIgnED NOT NULL,

       UNIQUE KEY `MovementID` (`MovementID`),
       UNIQUE KEY `Title` (`Title`),
       FULLTEXT KEY `Text` (`Text`),
       KEY `PowerIndex` (`PowerIndex`),
       KEY `Date` (`Date`),
       KEY `CreatorID` (`CreatorID`),
       KEY `NumSupporters` (`NumSupporters`),
       FULLTEXT(Title, Text)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Supporters`;

CREATE TABLE `Supporters` (
       `MovementID` BIGINT UNSIGNED NOT NULL,
       `SupporterID` BIGINT UNSIGNED NOT NULL,

       KEY `MovementID` (`MovementID`),
       KEY `SupporterID` (`SupporterID`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `MovementComments`;

CREATE TABLE `MovementComments` (
       `MovementID` BIGINT UNSIGNED NOT NULL,
       `UserID` BIGINT UNSIGNED NOT NULL,
       `Text` VARCHAR(128) NOT NULL,
       `Date` DATETIME NOT NULL,
       `CommentsIdentifier` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

       KEY `Date` (`Date`),
       KEY `UserID` (`UserID`),
       FULLTEXT KEY `Text` (`Text`),
       KEY `MovementID` (`MovementID`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `NewsComments`;

CREATE TABLE `NewsComments` (
	`NewsIdentifier` VARCHAR(13) NOT NULL,
	`UserID` BIGINT UNSIGNED NOT NULL,
	`Text` VARCHAR(128) NOT NULL,
	`Date` DATETIME NOT NULL,
	`CommentsIdentifier` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	
	KEY `Date` (`Date`),
	KEY `UserID` (`UserID`),
	FULLTEXT KEY `Text` (`Text`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Conversations`;

CREATE TABLE `Conversations` (
       `UserID1` BIGINT UNSIGNED NOT NULL,
       `UserID2` BIGINT UNSIGNED NOT NULL,

       KEY `UserID1` (`UserID1`),
       KEY `UserID2` (`UserID2`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Messages`;

CREATE TABLE `Messages` (
       `SenderID` BIGINT UNSIGNED NOT NULL,
       `ReceiverID` BIGINT UNSIGNED NOT NULL,
       `Text` VARCHAR(256) NOT NULL,
       `Date` DATETIME NOT NULL,

       KEY `SenderID` (`SenderID`),
       KEY `ReceiverID` (`ReceiverID`),
       FULLTEXT KEY `Text` (`Text`),
       KEY `Date` (`Date`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `News`;

CREATE TABLE `News` (
       `UserID` BIGINT UNSIGNED NOT NULL,
       `RegarderID` BIGINT UNSIGNED NOT NULL,
       `Title` VARCHAR(128) NOT NULL,
       `Text` VARCHAR(128) NOT NULL,
       `Data` BIGINT UNSIGNED NOT NULL,
       `Date` DATETIME NOT NULL,
  	`Type` VARCHAR(20) NOT NULL,
  	`identifier` VARCHAR(13) NOT NULL,
	`NewsID` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

       KEY `UserID` (`UserID`),
       KEY `RegarderID` (`RegarderID`),
       FULLTEXT KEY `Title` (`Title`),
       FULLTEXT KEY `Text` (`Text`),
       KEY `Date` (`Date`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `AllNews`;

CREATE TABLE `AllNews` (
	`RegarderID` BIGINT UNSIGNED NOT NULL,
       `Title` VARCHAR(64) NOT NULL,
       `Text` VARCHAR(128) NOT NULL,
       `Data` BIGINT UNSIGNED NOT NULL,
       `Date` DATETIME NOT NULL,
  	`Type` VARCHAR(20) NOT NULL,
  	`identifier` VARCHAR(13) NOT NULL,
	`NewsID` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

       KEY `RegarderID` (`RegarderID`),
       FULLTEXT KEY `Title` (`Title`),
       FULLTEXT KEY `Text` (`Text`),
       KEY `Date` (`Date`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `FactionConnection`;

CREATE TABLE `FactionConnection` (
       `MovementID` BIGINT UNSIGNED NOT NULL,
       `FactionID` BIGINT UNSIGNED NOT NULL,

       KEY `MovementID` (`MovementID`),
       KEY `FactionID` (`FactionID`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Faction`;

CREATE TABLE `Faction` (
       `FactionID` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
       `PrivatePublic` TINYINT UNSIGNED NOT NULL,
       `CreatorID` BIGINT UNSIGNED NOT NULL,
	`Title` VARCHAR(100) NOT NULL,

       KEY `CreatorID` (`CreatorID`),
	FULLTEXT KEY `Title` (`Title`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `FactionMembers`;

CREATE TABLE `FactionMembers` (
       `FactionID` BIGINT UNSIGNED NOT NULL,
       `MemberID` BIGINT UNSIGNED NOT NULL,

       KEY `FactionID` (`FactionID`),
       KEY `MemberID` (`MemberID`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Notifications`;

CREATE TABLE `Notifications` (
	`UserID` BIGINT UNSIGNED NOT NULL,
	`Data` BIGINT UNSIGNED NOT NULL,
	`Type` VARCHAR(20) NOT NULL
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `MovementStatistics`;

CREATE TABLE `MovementStatistics` (
	`MovementID` BIGINT UNSIGNED NOT NULL,
	`SupporterGain` BIGINT UNSIGNED NOT NULL,
	`Date` DATETIME NOT NULL
)ENGINE=MyISAM DEFAULT CHARSET=latin1;