BEGIN TRY
    
    BEGIN TRANSACTION;
    UPDATE app_users
    SET 
        sEmail = d.sEmail,
        sMainPhoneNumber = d.sMainPhoneNumber
    FROM 
        app_users a
    INNER JOIN 
        data_ad_scripted_data d ON a.sEmployeeNumber = d.sEmployeeNumber
    WHERE 
        a.sEmail = '' OR a.sEmail = 'NULL';
    COMMIT TRANSACTION;
END TRY
BEGIN CATCH
    -- Rollback if errorr
    ROLLBACK TRANSACTION;

    -- boilerplate error stuff
    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    SELECT 
        @ErrorMessage = ERROR_MESSAGE(),
        @ErrorSeverity = ERROR_SEVERITY(),
        @ErrorState = ERROR_STATE();

    -- Raise the error to the calling application
    RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState);
END CATCH;