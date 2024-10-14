
BEGIN TRY
    -- Start a transaction
    BEGIN TRANSACTION;

    -- Update app_users based on changes in data_employees
    UPDATE app_users
    SET bIsActive = de.bActive
    FROM data_employees de
    WHERE de.iEmployeeNumber = app_users.sEmployeeNumber
      AND de.bActive <> app_users.bIsActive;

    -- Insert new users into app_users for new employees (sounds painful)
    INSERT INTO app_users (sEmployeeNumber, bIsActive, sEmail, SMainPhoneNumber, SMainPhoneNumberLabel, sFirstName, sLastName, iDepartmentNumber, sUserName)
    SELECT de.iEmployeeNumber, de.bActive, de.sEmail, de.SMainPhoneNumber, de.SMainPhoneNumberLabel, de.sFirstName, de.sLastName, de.iDepartmentNumber, CONCAT(de.sFirstName, '.', de.sLastName)
    FROM data_employees de
    LEFT JOIN app_users au ON de.iEmployeeNumber = au.sEmployeeNumber
    WHERE au.sEmployeeNumber IS NULL;

    -- Commit transactoin
    COMMIT TRANSACTION;
END TRY
BEGIN CATCH
    -- Back that butt up if transaction poops out
    IF @@TRANCOUNT > 0
        ROLLBACK TRANSACTION;

    -- Log what I did wrong
    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    SELECT 
        @ErrorMessage = ERROR_MESSAGE(),
        @ErrorSeverity = ERROR_SEVERITY(),
        @ErrorState = ERROR_STATE();

    -- Raise the error because Stack Overflow said I needed to 
    RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState);
END CATCH;