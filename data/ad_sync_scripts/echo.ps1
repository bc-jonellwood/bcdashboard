Get-ADUser -Filter * -SearchBase "DC=berkeleycounty,DC=int" -Properties @("EmployeeID", "OfficePhone", "EmailAddress", "userAccountControl") | 
Select-Object -Property EmployeeID, EmailAddress, OfficePhone, @{
    Name       = 'AccountStatus'
    Expression = {
        if ($_.userAccountControl -band 2) {
            'Disabled'
        }
        else {
            'Enabled'
        }
    }
}





# Get-ADUser -Filter * -SearchBase "DC=berkeleycounty,DC=int" -Properties @("EmployeeID", "OfficePhone", "EmailAddress", "DistinguishedName") | 
# Select-Object -Property EmployeeID, EmailAddress, OfficePhone, @{
#     Name       = 'OrganizationalUnit'
#     Expression = {
#         $_.DistinguishedName -replace '^.+?,(?=(OU|DC)=.+$)'
#     }
# }



# Get-ADUser -Filter * -SearchBase "DC=berkeleycounty,DC=int" -Properties @("EmployeeID", "OfficePhone", "EmailAddress") | Select-Object -Property EmployeeID, EmailAddress, OfficePhone
