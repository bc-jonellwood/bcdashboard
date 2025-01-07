<?php
// Created: 2025/01/06 10:24:42
// Last modified: 2025/01/07 15:54:11

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/User.php');
include(dirname(__FILE__) . '/../classes/Department.php');
include(dirname(__FILE__) . '/../classes/DashboardItem.php');
// include(dirname(__FILE__) . '/../classes/SidenavItem.php');

$user = new User();
if (isset($_GET['id'])) {
    // var_dump($user);
    // die();
    $userData = $user->getUser($_GET['id']);
    $userDeps = $user->getUserAdditionalDepartments($_GET['id']);
    $userCards = $user->getUserDashboardItems($_GET['id']);
    $userSidenavItems = $user->getUserSidenavItems($_GET['id']);
    // print_r($userDeps);
}

echo '<div class="main">';
echo '<p class="user-name-display">' . ($userData['sPreferredName'] ? strtolower($userData['sPreferredName']) : strtolower($userData['sFirstName'])) . ' ' . strtolower($userData['sLastName']) . '</p>';
echo '<div class="content">';
echo '<div class="user-content" id="user-content">';
echo '<div class="user-form-data-only">';

echo '<div class="form-group">';
echo '<label for="first_name">First Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . htmlspecialchars($userData['first_name'] ?? 'None') . '</p>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="middle_name">Middle Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . htmlspecialchars($userData['middle_name'] ?? 'None') . '</p>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="lastName">Last Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . htmlspecialchars($userData['lastName'] ?? 'None') . '</p>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="preferredName">Preferred Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . htmlspecialchars($userData['preferredName'] ?? 'None') . '</p>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="email">Email <img src="/images/ad.png" alt="ad" class="edit-icon" /></label>';
echo '<p>' . htmlspecialchars($userData['email'] ?? 'None') . '</p>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="employeeNumber">Employee Number <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . htmlspecialchars($userData['employeeNumber'] ?? 'None') . '</p>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="sADStatus">Active Directory Status <img src="/images/ad.png" alt="ad" class="edit-icon" /></label>';
echo '<p>' . ($userData['sADStatus'] == '1' ? 'Active' : 'Inactive') . '</p>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="departmentName">Department Name <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . htmlspecialchars($userData['departmentName'] ?? 'None') . '</p>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="jobTitle">Job Title <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . htmlspecialchars($userData['jobTitle'] ?? 'None') . '</p>';
echo '</div>';  // close form-group

echo '<div class="form-group">';
echo '<label for="lastLogin">Last Login <img src="/images/app.png" alt="app" class="edit-icon"/></label>';
echo '<p>' . (!empty($userData['lastLogin']) ? htmlspecialchars($userData['lastLogin']) : 'No Data') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="lastSystemUpdate">Last System Update <img src="/images/app.png" alt="app" class="edit-icon"/></label>';
echo '<p>' . (!empty($userData['lastSystemUpdate']) ? htmlspecialchars($userData['lastSystemUpdate']) : 'No Data') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="startDate">Start Date <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . (!empty($userData['startDate']) ? htmlspecialchars($userData['startDate']) : 'No Data') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="separationDate">Separation Date <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<p>' . (!empty($userData['separationDate']) ? htmlspecialchars($userData['separationDate']) : 'No Data') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="mainPhoneNumber">Main Phone Number <img src="/images/ad.png" alt="ad" class="edit-icon" /></label>';
echo '<p>' . (!empty($userData['mainPhoneNumber']) ? htmlspecialchars($userData['mainPhoneNumber']) : 'None') . '</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="secondaryPhoneNumber">Secondary Phone Number <img src="/images/ad.png" alt="ad" class="edit-icon"/></label>';
echo '<p>' . (!empty($userData['secondaryPhoneNumber']) ? htmlspecialchars($userData['secondaryPhoneNumber']) : 'None') . '</p>';
echo '</div>'; // close form-group
echo '</div>'; // close user-form-data-only

echo '<div class="legend">';
// echo '<h3>Legend</h3>';
echo '<p class="legend-text"><img src="/images/ad.png" alt="ad" /> edit in Active Directory</p>';
echo '<p class="legend-text"><img src="/images/database.png" alt="ad" /> edit in Finance Enterprise</p>';
echo '<p class="legend-text"><img src="/images/app.png" alt="app" /> generated in myBerkeley App</p>';
echo '</div>'; // close legend

echo '<div class="divider"></div>';

echo '</div>'; // close form-group
// echo '<form method="POST" action="update.php">';
echo '<input type="hidden" id="userId" name="id" value="' . $userData['id'] . '">';

echo '<h3>Options</h3>';
echo '<div class="options-ribbon">';
echo '<div class="form-group">';
echo '<label for="bIsLDAP">Is LDAP';
echo '<input type="checkbox" name="bIsLDAP"' . (intval($userData['bIsLDAP']) === 1 ? 'checked' : '') . '>';
echo '</label>';
echo '</div>'; // close form-group
echo '</div>'; // close options-ribbon

echo '<div class="form-group">';
echo '<label for="bIsAdmin">Is Admin';
// echo '<input type="checkbox" name="bIsAdmin" checked= ' . (intval($user['bIsAdmin']) === 1 ? 'checked' : '')  . '>';
echo '<input type="checkbox" name="bIsAdmin"' . (intval($userData['bIsAdmin']) === 1 ? 'checked' : '') . '>';
echo '</label>';
echo '</div>'; // close form-group

echo '<div class="form-group">';
echo '<label for="bHideBirthday">Hide Birthday';
echo '<input type="checkbox" name="bHideBirthday"' . (intval($userData['bHideBirthday']) === 1 ? 'checked' : '')  . '>';
echo '</label>';
echo '</div>'; // close form-group
echo '<button type=button" class="btn btn-primary" onclick="updateOptions()">Update Options</button>';
// echo '</div>'; // close options-ribbon

echo '<div class="divider"></div>';

echo '<div class="motor-pool">';
echo '<h3><b>Motor Pool</b></h3>';
echo '<div class="form-group">';
// echo '<div>';
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
} else {
    echo '<button class="btn btn-primary btn-sm" type="button" onclick="createDriver(' . $userData['id'] . ')">Create Driver</button>';
}
// echo '</div>';
echo '</div>'; // close form-group
echo '</div>'; // close motor-pool

echo '<div class="divider"></div>';

echo '<div class="department-data">';
echo '<h3><b>Departments </b></h3>';
echo '<p><b>Assigned Department:</b> ' . $userData['sDepartmentName'] . '(' . $userData['iDepartmentNumber'] . ')' . '</p>';
echo '<p><b>Additional Access Departments:</b><ul>';
foreach ($userDeps as $dep) {
    echo '<li>' . $dep['sDepartmentName'] . '(' . $dep['iDepartmentNumber'] . ') </li>';
}
echo '</ul>';

$department = new Department();
$departments = $department->getDepartments();
echo '<div class="form-group">';
echo '<details>';
echo '<summary>';
echo '<p><b>Add Departments</b> - Use Ctrl + Click to select multiple. Unselect to remove access.</p>';
echo '</summary>';
echo '<div class="select-box" id="departments">';
foreach ($departments as $department) {
    $selected = '';
    foreach ($userDeps as $dep) {
        if ($department['iDepartmentNumber'] == $dep['iDepartmentNumber']) {
            $selected = 'checked';
            break;
        }
    }
    echo '<label for="' . $department['iDepartmentNumber'] . '">' . $department['sDepartmentName'] . '<input type="checkbox" id="' . $department['iDepartmentNumber'] . '" value="' . $department['iDepartmentNumber'] . '" name="departments[]" ' . $selected . '/></label>';
}
echo "</div>";
echo '<button class="btn btn-primary btn-sm" type="button" onclick="updateDepartments()">Update Departments</button>';
echo '</details>';
echo '</div>';
echo '</div>';

$dashboardItems = new DashboardItem();
$dashboardItems = $dashboardItems->getDashboardItems();
echo '<div class="divider"></div>';
echo '<div class="form-group">';
echo '<details><summary>';
echo '<p><b>Dashboard Items Access</b> - - Use Ctrl + Click to select multiple. Unselect to remove access.</p></summary>';
echo '<div class="dash-select-box" id="dashItems">';
foreach ($dashboardItems as $dashboardItem) {
    $selected = '';
    foreach ($userCards as $card) {
        if ($dashboardItem['sCardId'] == $card['sCardId']) {
            $selected = 'checked';
            break;
        }
    }

    echo '<label for="' . $dashboardItem['sCardId'] . '">' . $dashboardItem['sCardName'] . '<input type="checkbox" id="' . $dashboardItem['sCardId'] . '" value="' . $dashboardItem['sCardId'] . '" name="cardItems[]" ' . $selected . '/></label>';
}
echo '</div>';
echo '<button class="btn btn-primary btn-sm" type="button" onclick="updateCards()">Update Cards</button>';
echo '</div>';
// echo '</div>';

$sidenavItems = new SidenavItem();
$allSidenavItems = $sidenavItems->getAllSidenavItems();
// echo var_dump($userSidenavItems);
// echo var_dump($allSidenavItems);
echo '<div class="divider"></div>';
echo '<div class="form-group">';
echo '<details><summary>';
echo '<p><b>Sidenav Items Access</b> - Use Ctrl + Click to select multiple. Unselect to remove access.</p></summary>';
echo '<div class="sidenav-select-box" id="sidenavItems">';
foreach ($allSidenavItems as $sidenavItem) {
    $selected = '';
    foreach ($userSidenavItems as $userSidenavItem) {
        if ($userSidenavItem['sItemId'] == $sidenavItem['sItemId']) {
            $selected = 'checked';
            break;
        }
    }

    echo '<label for="' . $sidenavItem['sItemId'] . '">' . $sidenavItem['sItemText'] . '<input type="checkbox" id="' . $sidenavItem['sItemId'] . '" value="' . $sidenavItem['sItemId'] . '" name="sidenavItems[]" ' . $selected . '/></label>';
}
echo '</div>';
echo '<button class="btn btn-primary btn-sm" type="button" onclick="updateNavItems()">Update Nav Items</button>';
echo '</div>';
echo '</div>';

echo '<div class="divider"></div>';

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
        // console.log(departmentSelect);
        const selectedValues = [];
        const checkboxes = document.querySelectorAll('#departments input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedValues.push(checkbox.value)
            }
        })
        return selectedValues;
    }

    function updateDepartments() {
        // alert('Updated those Departments');
        var userId = document.getElementById('userId').value;
        var departmentSelect = document.getElementById('departments');
        var departments = getSelectedDepartments(departmentSelect);
        fetch("/API/updateUserDepartments.php?userId=" + userId + "&departments=" + departments)
            .then(window.location.reload())

    }

    function getSelectedCards(cardSelect) {
        const selectedValues = [];
        const checkboxes = document.querySelectorAll('#dashItems input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedValues.push(checkbox.value)
            }
        })
        return selectedValues;
    }

    function updateCards() {
        var userId = document.getElementById('userId').value;
        var cardSelect = document.getElementById('dashItems')
        var cards = getSelectedCards(cardSelect);
        fetch("/API/updateUserCards.php?userId=" + userId + "&cards=" + cards)
            .then(window.location.reload())
    }

    function createDriver(userId) {
        alert('Creating Driver for User ID ' + userId);
    }

    function updateNavItems() {
        alert('Updated those Nav Items');
    }
</script>


<?php
include_once(dirname(__FILE__) . '/../components/footer.php');
?>