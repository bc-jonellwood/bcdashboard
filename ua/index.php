<?php
// Created: 2025/01/02 07:57:37
// Last modified: 2025/01/08 14:43:38

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/User.php');


$user = new User();

$defaultLastNameStartsWith = 'A';
$defaultEnabled = 1;
$defaultTemp = 1;
if (!isset($_GET['lastNameStartsWith']) || !isset($_GET['enabled']) || !isset($_GET['temp'])) {
    header('Location: ?lastNameStartsWith=' . $defaultLastNameStartsWith . '&enabled=' . $defaultEnabled . '&temp=' . $defaultTemp);
    exit();
}
$enabled = (int) $_GET['enabled']; // Convert to integer for consistency
$temp = (int) $_GET['temp'];       // Convert to integer for consistency
// $activeFilterEnabled = $_GET['enabled'] === '1';
// $tempFilterEnabled = $_GET['temp'] === '1';
$lastNameStartsWith = $_GET['lastNameStartsWith'];


$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 250;
$offset = ($page - 1) * $limit;

// $users = $user->getUsers($limit, $offset, $activeFilterEnabled, $tempFilterEnabled, $lastNameStartsWith);
$users = $user->getUsers($limit, $offset, $enabled, $temp, $lastNameStartsWith);
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
    echo '<li><a href="?lastNameStartsWith=' . $letter . '&enabled=' . $enabled . '&temp=' . $temp . '">' . $letter . '</a></li>';
}
// echo '</ul></div>'; // commenting out just to see if I can stick these buttons in the same div as the pagination so I can mke it sticky
echo '</ul>';
// echo '<div>
// <a href="?lastNameStartsWith=' . $lastNameStartsWith . '&enabled=0&temp=' . $tempFilterEnabled . '" class="btn btn-primary">Show Inactive</a>
// <a href="?lastNameStartsWith=' . $lastNameStartsWith . '&enabled=' . $activeFilterEnabled . '&temp=0" class="btn btn-primary">Show Temp Employees</a>
// <a href="?lastNameStartsWith=' . $lastNameStartsWith . '" class="btn btn-info">Reset Filters</a>
// </div>';
?>
<div class="d-flex flex-row gap-2 justify-content-evenly">
    <div>
        <a href="?lastNameStartsWith=<?= $lastNameStartsWith ?>&enabled=<?= $enabled == 1 ? 0 : 1 ?>&temp=<?= $temp ?>" class="btn btn-primary">
            <?= $enabled == 1 ? 'Show Inactive' : 'Remove Inactive' ?>
        </a>

        <a href="?lastNameStartsWith=<?= $lastNameStartsWith ?>&enabled=<?= $enabled ?>&temp=<?= $temp == 1 ? 0 : 1 ?>" class="btn btn-primary">
            <?= $temp == 1 ? 'Show Temp Employees' : 'Remove Temp Employees' ?>
        </a>

        <a href="?lastNameStartsWith=<?= $defaultLastNameStartsWith ?>&enabled=<?= $defaultEnabled ?>&temp=<?= $defaultTemp ?>" class="btn btn-info">
            Reset Filters
        </a>
    </div>
    <div>
        <input type="text" id="myInput" onkeyup="filterUsers()" placeholder="Search for names..">
    </div>
</div>
</div>

<?php

// <a href="?lastNameStartsWith=' . $lastNameStartsWith . '&enabled=1&temp=1" class="btn btn-primary">Remove Both</a>
// echo '<h1>Users (' . $totalUsers . ') | Page ' . $page . '</h1>
echo '<table class="table table-sm table-bordered border-primary" id="userTable">
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
    echo '<td class="name">' .
        (isset($user['sPreferredName']) && $user['sPreferredName']
            ? strtolower($user['sPreferredName']) . ' ' . strtolower($user['sLastName'])
            : strtolower($user['sFirstName']) . ' ' . strtolower($user['sLastName'])) .
        '</td>';

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
echo '
</table>';
// echo '<div class="pagination">';
// for ($i = 1; $i <= $totalPages; $i++) {
// $url="?page=$i" . ($activeFilterEnabled ? "&enabled=true" : "" );
// echo "<a href='$url'>$i</a>" ;
// }
// echo '</div>' ;
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

<script>
    window.addEventListener('scroll', () => {
        const scrollPercent = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
        const userPagination = document.querySelector('.user-pagination');
        console.log(userPagination);

        if (scrollPercent > 2) {
            userPagination.classList.add('pagination-scrolled');
        } else {
            userPagination.classList.remove('pagination-scrolled');
        }
    });
</script>

<script>
    function filterUsers(str) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("userTable");
        tr = table.getElementsByTagName("tr");
        // console.log('tr', tr);
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js">
</script> -->
<?php
include_once(dirname(__FILE__) . '/../components/footer.php');
?>