<?php
class EmployeeManagement
{
    private $allEmployees = [];
    private $permissions = [];

    public function getAllEmployees()
    {
        include_once "../data/appConfig.php";

        $dbconf = new appConfig;
        $serverName = $dbconf->serverName;
        $database = $dbconf->database;
        $uid = $dbconf->uid;
        $pwd = $dbconf->pwd;


        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            // echo "Connection failed: " . $e->getMessage();
        }
        try {

            $sql = "SELECT au.id as userId, au.sFirstName, de.sMiddleName, au.sLastName, de.sPreferredName, au.sEmployeeNumber, au.iDepartmentNumber,  dd.sDepartmentName, de.dtStartDate
from app_users au
JOIN data_employees de on de.iEmployeeNumber = au.sEmployeeNumber
JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
where de.dtSeparationDate is null 
order by de.dtStartDate DESC";

            try {
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $this->allEmployees;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            $conn = null;
        } catch (Exception $e) {
            throw new Exception("Error fetching employees: " . $e->getMessage());
        }
    }

    public function renderAllEmployeesSelect()
    {
        $employees = $this->getAllEmployees();
        $html = '<ul id="employee-list">';

        foreach ($employees as $employee) {
            $displayName = !empty($employee['sPreferredName'])
                ? $employee['sPreferredName']
                : $employee['sFirstName'];

            $html .= sprintf(
                '<li data-user-id="%s" onclick="selectAsNewUser(\'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\')">%s %s (%s)</li>',
                $employee['userId'],
                $employee['userId'],
                $employee['sFirstName'],
                $employee['sLastName'],
                $employee['sEmployeeNumber'],
                $employee['iDepartmentNumber'],
                $employee['sDepartmentName'],
                $employee['dtStartDate'],
                $employee['sMiddleName'],
                $employee['sPreferredName'],
                htmlspecialchars($displayName),
                htmlspecialchars($employee['sLastName']),
                htmlspecialchars($employee['sEmployeeNumber'])
            );
        }

        $html .= '</ul>';
        return $html;
    }

    public function generateSelectedUserHtml($userData)
    {
        $html = sprintf(
            '
            <button class="btn btn-warning" onclick="reset()">Start Over</button>
            <div class="selected-holder">
                <input type="hidden" name="newUserId" id="newUserId" value="%s">
                <span class="d-flex justify-content-start flex-row">Selected: %s %s %s - 
                    <p id="newUserRequestEmployeeNumber">%s</p>
                </span>
                <span class="d-flex justify-content-start flex-row">Preferred Name: %s</span>
                <span class="d-flex justify-content-start flex-row">Department: %s (%s)</span>
                <span class="d-flex justify-content-start flex-row">Start Date: %s</span>
            </div>',
            htmlspecialchars($userData['userId']),
            strtolower(htmlspecialchars($userData['firstName'])),
            strtolower(htmlspecialchars($userData['middleName'])),
            strtolower(htmlspecialchars($userData['lastName'])),
            htmlspecialchars($userData['employeeNumber']),
            strtolower(htmlspecialchars($userData['preferredName'])),
            htmlspecialchars($userData['departmentName']),
            htmlspecialchars($userData['departmentNumber']),
            htmlspecialchars($userData['startDate'])
        );

        return $html;
    }
}

// Usage example:
try {
    $employeeManager = new EmployeeManagement();

    // To render the employee list
    echo $employeeManager->renderAllEmployeesSelect();

    // To handle the selection of a new user (this would be in your AJAX handler)
    if (isset($_POST['action']) && $_POST['action'] === 'selectNewUser') {
        $userData = [
            'userId' => $_POST['userId'],
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'employeeNumber' => $_POST['employeeNumber'],
            'departmentNumber' => $_POST['departmentNumber'],
            'departmentName' => $_POST['departmentName'],
            'startDate' => $_POST['startDate'],
            'middleName' => $_POST['middleName'],
            'preferredName' => $_POST['preferredName']
        ];

        echo $employeeManager->generateSelectedUserHtml($userData);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
