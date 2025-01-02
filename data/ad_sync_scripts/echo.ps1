$users = Get-ADUser -Filter * -SearchBase "DC=berkeleycounty,DC=int" -Properties @("EmployeeID", "OfficePhone", "EmailAddress", "userAccountControl", "mobile") | 
Select-Object -Property EmployeeID, EmailAddress, OfficePhone, mobile, @{
    Name       = 'AccountStatus'
    Expression = {
        if ($_.userAccountControl -band 2) {
            0
        }
        else {
            1
        }
    }
}
$users | ConvertTo-Json -Depth 3

# if ($users) {
#     return $users
# }
# else {
#     Write-Host "No users found."
# }

# Get-ADUser -Filter * -SearchBase "DC=berkeleycounty,DC=int" -Properties @("EmployeeID", "OfficePhone", "EmailAddress", "DistinguishedName") | 
# Select-Object -Property EmployeeID, EmailAddress, OfficePhone, @{
#     Name       = 'OrganizationalUnit'
#     Expression = {
#         $_.DistinguishedName -replace '^.+?,(?=(OU|DC)=.+$)'
#     }
# }



# Get-ADUser -Filter * -SearchBase "DC=berkeleycounty,DC=int" -Properties @("EmployeeID", "OfficePhone", "EmailAddress") | Select-Object -Property EmployeeID, EmailAddress, OfficePhone
