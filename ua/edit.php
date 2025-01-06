<?php
// Created: 2025/01/06 10:24:42
// Last modified: 2025/01/06 15:40:11

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/User.php');
include(dirname(__FILE__) . '/../classes/Department.php');

$user = new User();
if (isset($_GET['id'])) {
    // var_dump($user);
    // die();
    $userData = $user->getUser($_GET['id']);
    $userDeps = $user->getUserAdditionalDepartments($_GET['id']);
    // print_r($userDeps);
}

echo '<div class="main">';
echo '<div class="content">';
echo '<div class="user-content" id="user-content">';
echo '<div class="user-form-data-only">';

echo '<div class="form-group">';
echo '<label for="sFirstName">First Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['sFirstName'] ? $userData['sFirstName'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sMiddleName">Middle Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['sMiddleName'] ? $userData['sMiddleName'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sPreferredName">Preferred Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['sPreferredName'] ? $userData['sPreferredName'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sLastName">Last Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['sLastName'] ? $userData['sLastName'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sEmail">Email <img src="/images/ad.png" alt="ad" class="edit-icon" /></label>';
echo '<p>' . ($userData['sEmail'] ? $userData['sEmail'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sEmployeeNumber">Employee Number <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['sEmployeeNumber']  ? $userData['sEmployeeNumber'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sADStatus">Active Directory Status <img src="/images/ad.png" alt="ad" class="edit-icon" /></label>';
echo '<p>' . ($userData['sADStatus'] == '1' ? 'Active' : 'Inactive') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sDepartmentName">Department Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['sDepartmentName'] ? $userData['sDepartmentName'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sJobTitle">Job Title <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['sJobTitle'] ? $userData['sJobTitle'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="dtLastLogin">Last Login<img src="/images/app.png" alt="app" class="edit-icon"/></label>';
echo '<p>' . ($userData['dtLastLogin'] ? $userData['dtLastLogin'] : 'No Data') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="dtLastSystemUpdate">Last System Update<img src="/images/app.png" alt="app" class="edit-icon"/></label>';
echo '<p>' . ($userData['dtLastSystemUpdate'] ? $userData['dtLastSystemUpdate'] : 'No Data') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="dtStartDate">Start Date<img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['dtStartDate'] ? $userData['dtStartDate'] : 'No Data') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="dtSeparationDate">Separation Date<img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . ($userData['dtSeparationDate'] ? $userData['dtSeparationDate'] : 'No Data') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sMainPhoneNumber">Main Phone Number <img src="/images/ad.png" alt="ad" class="edit-icon" /></label>';
echo '<p>' . ($userData['sMainPhoneNumber'] ? $userData['sMainPhoneNumber'] : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="sSecondaryPhoneNumber">Secondary Phone Number <img src="/images/ad.png" alt="ad" class="edit-icon"/></label>';
echo '<p>' . ($userData['sSecondaryPhoneNumber'] ? $userData['sSecondaryPhoneNumber'] : 'None') . '</p>';
echo '</div>';



echo '<div class="legend">';
echo '<h3>Legend</h3>';
echo '<p class="legend-text"><img src="/images/ad.png" alt="ad" /> edit in Active Directory</p>';
echo '<p class="legend-text"><img src="/images/database.png" alt="ad" /> edit in Finance Enterprise</p>';
echo '<p class="legend-text"><img src="/images/app.png" alt="app" /> generated in myBerkeley App</p>';
echo '</div>';

echo '<div class="divider"></div>';

echo '</div>';
// echo '<form method="POST" action="update.php">';
echo '<input type="hidden" id="userId" name="id" value="' . $userData['id'] . '">';

echo '<h3>Options</h3>';
echo '<div class="options-ribbon">';
echo '<div class="form-group">';
echo '<label for="bIsLDAP">Is LDAP';
echo '<input type="checkbox" name="bIsLDAP"' . (intval($userData['bIsLDAP']) === 1 ? 'checked' : '') . '>';
echo '</label>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="bIsAdmin">Is Admin';
// echo '<input type="checkbox" name="bIsAdmin" checked= ' . (intval($user['bIsAdmin']) === 1 ? 'checked' : '')  . '>';
echo '<input type="checkbox" name="bIsAdmin"' . (intval($userData['bIsAdmin']) === 1 ? 'checked' : '') . '>';
echo '</label>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="bHideBirthday">Hide Birthday';
echo '<input type="checkbox" name="bHideBirthday"' . (intval($userData['bHideBirthday']) === 1 ? 'checked' : '')  . '>';
echo '</label>';
echo '</div>';
echo '<button type=button" class="btn btn-primary" onclick="updateOptions()">Update Options</button>';
echo '</div>';

echo '<div class="divider"></div>';

echo '<div class="motor-pool">';
echo '<h3><b>Motor Pool</b></h3>';
echo '<div class="form-group">';
echo '<p>';
if ($userData['iDriverId']) {
    // echo '<div class="mp-driver-data">';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Driver ID</th>';
    echo '<th scope="col">Fleet Test Passed</th>';
    echo '<th scope="col">Fuel Card Test Passed</th>';
    echo '<th scope="col">Acknowledgement Received</th>';
    echo '<th scope="col">DL Expiration Date</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr>';
    echo '<td>' . $userData['iDriverId'] . '</td>';
    echo '<td>' . $userData['dtFleetTestPassed'] . '</td>';
    echo '<td>' . $userData['dtFuelCardTestPassed'] . '</td>';
    echo '<td>' . $userData['dtAcknowledge'] . '</td>';
    echo '<td>' . $userData['dtDlExpires'] . '</td>';
    echo '</tr>';
    echo '</tbody>';
    echo '<p><a href="/mp/mpdrivers.php" class="btn btn-primary btn-sm">Edit in Motor Pool App</a>' . '</p>';
    echo '</table>';
    // echo '<p><b>Driver ID:</b> ' . $user['iDriverId'] . '</p>';
    // echo '<p><b>Fleet Test Passed:</b> ' . $user['dtFleetTestPassed'] . '</p>';
    // echo '<p><b>Fuel Card Test Passed:</b> ' . $user['dtFuelCardTestPassed'] . '</p>';
    // echo '<p><b>Acknowledgement Received:</b> ' . $user['dtAcknowledge'] . '</p>';
    // echo '<p><b>DL Expiration Date:</b> ' . $user['dtDlExpires'] . '</p>';
    // echo '<p><a href="/mp/mpdrivers.php" class="btn btn-primary btn-sm">Edit in Motor Pool App</a>' . '</p>';
    // echo '</div>';
} else {
    echo '<button class="btn btn-primary btn-sm" type="button">Create Driver</button>';
}
echo '</p>';

echo '<div class="divider"></div>';

echo '<div class="department-data">';
echo '<h3><b>Departments </b></h3>';
echo '<p><b>Assigned Department:</b> ' . $userData['sDepartmentName'] . '(' . $userData['iDepartmentNumber'] . ')' . '</p>';
echo '<p><b>Additional Access Departments:</b><ul>';
foreach ($userDeps as $dep) {
    echo '<li>' . $dep['sDepartmentName'] . '(' . $dep['iDepartmentNumber'] . ') </li>';
}
'</ul>';

$department = new Department();
$departments = $department->getDepartments();
// include_once(dirname(__FILE__) . '/../components/departmentMultiSelect.php');
echo '<div class="form-group">';
echo '<details>';
echo '<summary>';
echo '<label for="departments">Departments <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>Use Ctrl + Click to select multiple</p>';
echo '</summary>';
echo '<select class="form-control" id="departments" name="departments[]" multiple>';
foreach ($departments as $department) {
    echo '<option value="' . $department['iDepartmentNumber'] . '">' . $department['sDepartmentName'] . '</option>';
}
echo '</select>';
echo '<button class="btn btn-primary btn-sm" type="button" onclick="updateDepartments()">Update Departments</button>';
echo '</details>';
echo '</div>';
echo "</div>";


echo "</div>";
echo "</div>";


echo '<div class="user-form">';
// echo '<button type="submit" class="btn btn-primary">Update</button>';
// echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

?>
<link rel="stylesheet" type="text/css" href="users.css">
<script>
    function updateOptions() {
        alert('Updated those Options');
    }

    function getSelectedDepartments(departmentSelect) {
        const selectedValues = [];

        for (const option of departmentSelect.options) {
            if (option.selected) {
                selectedValues.push(option.value);
            }
        }
        return selectedValues;
    }

    function updateDepartments() {
        // alert('Updated those Departments');
        var userId = document.getElementById('userId').value;
        var departmentSelect = document.getElementById('departments');
        var departments = getSelectedDepartments(departmentSelect);
        fetch("/API/updateUserDepartments.php?userId=" + userId + "&departments=" + departments)
            .then(console.log('userId', userId))
            .then(console.log('departments', departments))
    }
</script>


<?php
include_once(dirname(__FILE__) . '/../components/footer.php');
?>