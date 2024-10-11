UPDATE de
SET 
    de.sEmail = COALESCE(te.sEmail, de.sEmail),
    de.sMainPhoneNumber = COALESCE(te.sMainPhoneNumber, de.sMainPhoneNumber)
FROM data_employees de
JOIN data_ad te ON de.iEmployeeNumber = te.iEmployeeNumber
WHERE te.iEmployeeNumber IS NOT NULL;