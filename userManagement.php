<?php
// Created: 2024/10/31 11:23:38
// Last modified: 2024/11/06 11:24:50

require_once './data/appConfig.php';
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;
include_once "./components/header.php";

include_once "./components/sidenav.php";
echo "<div class='main'>";
try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $conn = new PDO(
    //     "sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true;TrustServerCertificate=true",
    //     $uid,
    //     $pwd
    // );
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $limit = 100;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    // echo "Connected successfully";
    $sql =
        "SELECT au.id,
    au.sUserName,
    au.sEmployeeNumber,
    au.sFirstName,
    au.sLastName,
    au.iDepartmentNumber,
    dd.sDepartmentName,
    au.sEmail,
    au.sMainPhoneNumber,
    au.sMainPhoneNumberLabel,
    au.bIsActive,
    au.bIsLDAP
    from app_users au
    join data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
    where au.bIsActive = 1
    order by au.sLastName
    OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':offset', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // $stmt = $conn->prepare($sql);
    // $stmt->execute();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($result);

    if (!empty($result)) {

        echo "<div class='content'>";
        echo "<table class='userManagementTable'>";
        echo "<tr>
                <th>Name</th>
                <th>Emp #</th>
                <th>Email Address</th>
                <th>Department</th>
                <th>Phone</th>
                <th>Active</th>
                <th></th>
            </tr>";

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars(strtolower($row['sFirstName'])) . ' ' . htmlspecialchars(strtolower($row['sLastName'])) . "</td>";
            echo "<td>" . htmlspecialchars($row['sEmployeeNumber']) . "</td>";
            echo "<td class='email'>" . htmlspecialchars($row['sEmail']) . "</td>";
            echo "<td>" . htmlspecialchars($row['sDepartmentName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['sMainPhoneNumber']) . "</td>";
            echo "<td>" . ($row['bIsActive'] ? 'true' : 'false') . "</td>";
            echo "<td><button class='btn btn-small btn-success' onclick='editUser(" . json_encode($row['id']) . ")'>Edit</button></td>";
            // echo "<td>" . ($row['bIsLDAP'] ? 'true' : 'false') . "</td>";
            // echo "<td>" . htmlspecialchars($row['bIsLDAP']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // echo "</div>";
        $totalQuery = "SELECT COUNT(*) FROM app_users where bIsActive = 1";
        $totalStmt = $conn->prepare($totalQuery);
        $totalStmt->execute();
        $totalRecords = $totalStmt->fetchColumn();
        $totalPages = ceil($totalRecords / $limit);

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $startPage = max(1, $currentPage - 5);
        $endPage = min($totalPages, $currentPage + 5);

        echo "<div class='pagination'>";
        for ($i = $startPage; $i <= $endPage; $i++) {
            $activeClass = ($i === $currentPage) ? 'class="active"' : '';
            echo "<a href='?page=$i' $activeClass>$i</a> ";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "No results found.";
    }
    include_once "./components/footer.php";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>
<script>
    function editUser(id) {
        window.location.href = "editUser.php?id=" + id;
    }
</script>
<style>
    .main {
        font-size: medium;
        padding: 10px;
        /* display: grid;
        grid-template-rows: 1fr 1fr; */
    }

    .content {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    table {
        border-collapse: collapse;
        width: 90%;

        tr td {
            text-transform: capitalize;
            padding: 5px;
            border-bottom: 1px solid var(--accent);
        }

        .email {
            text-transform: none;
        }
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px 0;
        overflow: hidden;
    }

    .pagination a {
        padding: 10px 15px;
        margin: 0 5px;
        text-decoration: none;
        /* color: #007bff; */
        color: var(--accent);
        /* border: 1px solid #007bff; */
        border: 1px solid var(--accent);
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination a.active {
        background-color: var(--accent);
        color: var(--bg);
    }

    .pagination a:hover {
        /* background-color: #007bff; */
        background-color: var(--accent);
        color: var(--bg);
    }

    .pagination .first,
    .pagination .last {
        font-weight: bold;
    }

    .pagination .disabled {
        color: #ccc;
        pointer-events: none;
    }
</style>