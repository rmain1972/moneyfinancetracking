/* Secondary Database */
   
CREATE DATABASE MFT_U0000;
   
USE MFT_U0000;

CREATE TABLE Reconcile (
   recon_id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   PRIMARY KEY ( recon_id )
   );

INSERT INTO Reconcile (name) VALUES (" ");
INSERT INTO Reconcile (name) VALUES ("C");
INSERT INTO Reconcile (name) VALUES ("R");

   
CREATE TABLE CatType (
   cattype_id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   PRIMARY KEY ( cattype_id )
   );
   
INSERT INTO CatType (name) VALUES ("Income");
INSERT INTO CatType (name) VALUES ("Expense");
   
CREATE TABLE Accounts (
   account_id INT NOT NULL AUTO_INCREMENT,
   accountname VARCHAR(255) NOT NULL,
   startbaldate DATE NOT NULL,
   startingbalance DOUBLE NOT NULL,
   usertable VARCHAR(50) NOT NULL,
   PRIMARY KEY ( account_id )
   );
   
CREATE TABLE Categories (
   cat_id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL,
   Cattype_id INT NOT NULL,
   FOREIGN KEY (Cattype_id)
   REFERENCES CatType(cattype_id)
   ON DELETE CASCADE,
   PRIMARY KEY ( cat_id )
   );
   
 /* Income Categories */
 INSERT INTO Categories (name, Cattype_id) VALUES ("Paycheck",1);
 INSERT INTO Categories (name, Cattype_id) VALUES ("Other Income",1);
 
 /* Expense Categories */
 INSERT INTO Categories (name, Cattype_id) VALUES ("Utilities",2);
 INSERT INTO Categories (name, Cattype_id) VALUES ("Utilities:Electric",2);
 INSERT INTO Categories (name, Cattype_id) VALUES ("Utilities:Internet",2);
 INSERT INTO Categories (name, Cattype_id) VALUES ("Credit Card",2);
 INSERT INTO Categories (name, Cattype_id) VALUES ("Credit Card:Capital One",2);
 INSERT INTO Categories (name, Cattype_id) VALUES ("Miscellaneous Expense",2);
 
CREATE TABLE Transactions (
   0-transaction_id INT NOT NULL AUTO_INCREMENT,
   1-transdate DATE NOT NULL,
   2-payee VARCHAR(255) NOT NULL,
   3-category_id INT NOT NULL,
   4-debit DOUBLE NOT NULL,
   5-credit DOUBLE NOT NULL,
   6-recon_id INT NOT NULL,
   7-memo VARCHAR(512) NOT NULL,
   FOREIGN KEY (category_id)
   REFERENCES Categories(cat_id)
   ON DELETE CASCADE,
   PRIMARY KEY ( transaction_id )
   );
   
 
   
   
   
   
   
   
