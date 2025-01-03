BEGIN TRY

    BEGIN TRANSACTION;
    UPDATE app_users
    SET 
        sUserName = LEFT(sEmail, CHARINDEX('@', sEmail) - 1)
    WHERE 
        sEmail IS NOT NULL 
        AND sEmail <> ''
        AND sUserName IS NULL;
    COMMIT TRANSACTION;

END TRY
BEGIN CATCH
    -- Rollback if error
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
