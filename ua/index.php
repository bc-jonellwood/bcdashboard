<?php
// Created: 2025/01/02 07:57:37
// Last modified: 2025/01/02 13:07:45

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/User.php');

$user = new User();
$aciveFilterEnabled = isset($_GET['enabled']) && $_GET['enabled'] === 'true';
$tempFilterEnabled = isset($_GET['temp']) && $_GET['temp'] === 'true';
$lastNameStartsWith = isset($_GET['lastNameStartsWith']) ? $_GET['lastNameStartsWith'] : 'A';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 250;
$offset = ($page - 1) * $limit;
// $users = $user->getUsers($limit, $offset, $aciveFilterEnabled, $tempFilterEnabled);
$users = $user->getUsers($limit, $offset, $aciveFilterEnabled, $tempFilterEnabled, $lastNameStartsWith);
// $users = $user->getUsers();
$totalUsers = $user->getUserCount();
$totalPages = ceil($totalUsers / $limit);
echo '<div class="main">';
echo '<div class="content">';
echo '<div class="user-content" id="user-content">';
echo '<div class="user-pagination" id="user-pagination"> 
    <ul>';
$letters = range('A', 'Z');
foreach ($letters as $letter) {
    // echo '<li><a href="?lastNameStartsWith=' . $letter . '">' . $letter . '</a></li>';
    echo '<li><a href="?lastNameStartsWith=' . $letter . '&enabled=' . $aciveFilterEnabled . '&temp=' . $tempFilterEnabled . '">' . $letter . '</a></li>';
}
echo '</ul>
</div>';
echo '<div>
        <a href="?lastNameStartsWith=' . $lastNameStartsWith . '&enabled=true&temp=' . $tempFilterEnabled . '" class="btn btn-primary">Remove Inactive</a>
        <a href="?lastNameStartsWith=' . $lastNameStartsWith . '&enabled=' . $aciveFilterEnabled . '&temp=true" class="btn btn-primary">Remove Temp Employees</a>
        <a href="?lastNameStartsWith=' . $lastNameStartsWith . '" class="btn btn-info">Reset Filters</a>
    </div>';

// echo '<h1>Users (' . $totalUsers . ') | Page ' . $page . '</h1>
echo '<table class="table table-sm table-bordered border-primary">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>AD Status</th>
                        <th>Department</th>
                        <th>Employee Number</th>
                    </tr>
                </thead>
                <tbody>';

foreach ($users as $user) {
    echo '<tr>';
    echo '<td>' . $user['sFirstName'] . ' ' . $user['sLastName'] . '</td>';
    echo '<td>' . $user['sEmail'] . '</td>';
    echo '<td>' . $user['sADStatus'] . '</td>';
    echo '<td>' . $user['sDepartmentName'] . '</td>';
    echo '<td>' . $user['sEmployeeNumber'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
// echo '<div class="pagination">';
// for ($i = 1; $i <= $totalPages; $i++) {
//     $url = "?page=$i" . ($aciveFilterEnabled ? "&enabled=true" : "");
//     echo "<a href='$url'>$i</a>";
// }
// echo '</div>';
echo '</div>';
echo '</div>';


?>


<link rel="stylesheet" type="text/css" href="users.css">

<?php
include_once(dirname(__FILE__) . '/../components/footer.php');
?>