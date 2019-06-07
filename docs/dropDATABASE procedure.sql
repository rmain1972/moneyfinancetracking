-- SQL Procedure

DELIMITER //

CREATE PROCEDURE deleteExpired(OUT row_count)
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE UserDB VARCHAR(255);
	DECLARE Userid INT;
	DECLARE ExpireDate DATETIME;
	DECLARE statement text;
	
	DECLARE c1 CURSOR FOR
        SELECT user_id, database_name
		FROM Users
		WHERE expire_date < CURRENT_DATE();
		
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	
	SET row_count = 0;
	
	OPEN c1;
	
	deleteDB: LOOP
	
	FETCH c1 INTO UserID, UserDB;

	IF done = 1 THEN
	LEAVE deleteDB;
	END IF
	
	-- Delete User Database
	SET @statement = CONCAT('DROP DATABASE ', UserDB, ';');
	PREPARE STATEMENT FROM @statement;
	EXECUTE STATEMENT;
	DEALLOCATE PREPARE STATEMENT;
	
	-- Delete User FROM Users Table
	DELETE FROM Users WHERE user_id=UserID;
	
	SET row_count = row_count + 1;
	END LOOP deleteDB;
	
	CLOSE c1;
	
	END//
	
	DELIMITER ;
	
		