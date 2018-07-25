CREATE DATABASE MFT_DB;

USE MFT_DB;

CREATE TABLE Users (
   user_id INT NOT NULL AUTO_INCREMENT,
   username VARCHAR(255) NOT NULL UNIQUE,
   password VARCHAR(255) NOT NULL,
   email VARCHAR(255) NOT NULL,
   database_name  VARCHAR(255) NOT NULL,
   expire_date DATETIME NOT NULL,
   PRIMARY KEY ( user_id )
   );

CREATE TABLE UtilityTableVar (
	util_id INT NOT NULL AUTO_INCREMENT,
	dbuser_num INT NOT NULL,
	PRIMARY KEY (util_id)
);

INSERT INTO UtilityVar (dbuser_num) VALUES (0);
