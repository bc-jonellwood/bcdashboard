<?php
// Created: 2025/01/02 07:57:37
// Last modified: 2025/01/02 13:58:37

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/User.php');


$user = new User();
$activeFilterEnabled = isset($_GET['enabled']) && $_GET['enabled'] === '1';

$tempFilterEnabled = isset($_GET['temp']) && $_GET['temp'] === '1';

$lastNameStartsWith = isset($_GET['lastNameStartsWith']) ? $_GET['lastNameStartsWith'] : 'A';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 250;
$offset = ($page - 1) * $limit;
// $users = $user->getUsers($limit, $offset, $activeFilterEnabled, $tempFilterEnabled);
$users = $user->getUsers($limit, $offset, $activeFilterEnabled, $tempFilterEnabled, $lastNameStartsWith);
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
    echo '<li><a href="?lastNameStartsWith=' . $letter . '&enabled=' . $activeFilterEnabled . '&temp=' . $tempFilterEnabled . '">' . $letter . '</a></li>';
}
echo '</ul>
</div>';
echo '<div>
        <a href="?lastNameStartsWith=' . $lastNameStartsWith . '&enabled=1&temp=' . $tempFilterEnabled . '" class="btn btn-primary">Remove Inactive</a>
        <a href="?lastNameStartsWith=' . $lastNameStartsWith . '&enabled=' . $activeFilterEnabled . '&temp=1" class="btn btn-primary">Remove Temp Employees</a>
        <a href="?lastNameStartsWith=' . $lastNameStartsWith . '" class="btn btn-info">Reset Filters</a>
        </div>';

// <a href="?lastNameStartsWith=' . $lastNameStartsWith . '&enabled=1&temp=1" class="btn btn-primary">Remove Both</a>
// echo '<h1>Users (' . $totalUsers . ') | Page ' . $page . '</h1>
echo '<table class="table table-sm table-bordered border-primary">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account Status</th>
                        <th>Department</th>
                        <th>Employee Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

foreach ($users as $user) {
    echo '<tr>';
    echo '<td class="name">' . strtolower($user['sFirstName']) . ' ' . strtolower($user['sLastName']) . '</td>';
    echo '<td>' . strtolower($user['sEmail']) . '</td>';
    echo '<td>' . ($user['sADStatus'] == '1' ? 'Active' : 'Inactive') . '</td>';
    echo '<td>' . $user['sDepartmentName'] . '</td>';
    echo '<td>' . $user['sEmployeeNumber'] . '</td>';
    echo '<td>';
    echo '<div class="dropdown">';
    echo '<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    echo 'Actions';
    echo '</button>';
    echo '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
    echo '<a class="dropdown-item" href="edit.php?id=' . $user['id'] . '">Edit</a>';
    echo '<a class="dropdown-item" href="delete.php?id=' . $user['id'] . '">Delete</a>';
    echo '</div>';
    echo '</div>';
    echo '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
// echo '<div class="pagination">';
// for ($i = 1; $i <= $totalPages; $i++) {
//     $url = "?page=$i" . ($activeFilterEnabled ? "&enabled=true" : "");
//     echo "<a href='$url'>$i</a>";
// }
// echo '</div>';
echo '</div>';
echo '</div>';


?>


<link rel="stylesheet" type="text/css" href="users.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js">
</script> -->
<?php
include_once(dirname(__FILE__) . '/../components/footer.php');
?>