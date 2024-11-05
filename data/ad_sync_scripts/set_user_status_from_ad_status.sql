BEGIN TRY
    BEGIN TRANSACTION;

    UPDATE app_users
    SET 
        bIsActive = CASE 
                        WHEN data.sAccStatus = 'Enabled' THEN 1 
                        WHEN data.sAccStatus = 'Disabled' THEN 0 
                        WHEN data.sAccStatus IS NULL THEN 0
                        ELSE app_users.bIsActive 
                    END
    FROM 
        app_users
    INNER JOIN 
        data_ad_scripted_data AS data
    ON 
        app_users.sEmployeeNumber = data.sEmployeeNumber

    COMMIT TRANSACTION;
END TRY
BEGIN CATCH
    IF @@TRANCOUNT > 0
        ROLLBACK TRANSACTION;

    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    SELECT 
        @ErrorMessage = ERROR_MESSAGE(),
        @ErrorSeverity = ERROR_SEVERITY(),
        @ErrorState = ERROR_STATE();

    RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState);
END CATCH;
