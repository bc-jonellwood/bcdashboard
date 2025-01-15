<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2025/01/15 13:49:01

require_once(dirname(__FILE__) . '/../data/appConfig.php');
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;
include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
$pageId = '48f2fc7c-959a-4d4a-a3c3-4ccdf2a9c362';
$accessRequired = Page::getAccessRequired($pageId);
// echo "<pre>";
// print_r($accessRequired);
// echo "</pre>";
AccessControl::enforce($accessRequired);
// include_once "./components/sidenav.php";
function formatDateTime($dateTimeString)
{
    $dateTime = new DateTime($dateTimeString);
    return [
        'date' => $dateTime->format('m-d-Y'),
        'time' => $dateTime->format('H:i')
    ];
}
function getStatusString($value)
{
    // if (!is_int($value)) {
    //     throw new InvalidArgumentException("Input must be an integer.");
    // } 
    switch (intval($value)) {
        case 0:
            return "Emergency";
        case 1:
            return "Urgent";
        case 2:
            return "Normal";
        default:
            throw new InvalidArgumentException("Invalid input value. Accepted values are 0, 1, or 2.");
    }
}
function getTicketAge($dateTimeString)
{
    $dateTime = new DateTime($dateTimeString);
    $now = new DateTime();
    $interval = $now->diff($dateTime);

    if ($interval->y > 0) {
        return $interval->y . ' year' . ($interval->y > 1 ? 's' : '');
    } elseif ($interval->m > 0) {
        return $interval->m . ' month' . ($interval->m > 1 ? 's' : '');
    } elseif ($interval->d > 0) {
        return $interval->d . ' day' . ($interval->d > 1 ? 's' : '');
    } elseif ($interval->h > 0) {
        return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '');
    } elseif ($interval->i > 0) {
        return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '');
    } else {
        return 'just now';
    }
}
echo "<div class='main'>";
try {
    $conn = new PDO(
        "sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true;TrustServerCertificate=true",
        $uid,
        $pwd
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $limit = 100;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    $sql = "SELECT fr.id
      ,fr.sRequestId
      ,fr.dtRequestSubmitted
      ,fr.sIssueTitle
      ,fr.sIssueDescription
      ,fr.iIssueType
      ,rt.sType
      ,fr.sIssueLocation
      ,fl.sLocName
      ,fr.sIssueSubLocation
      ,fr.sRequestorName
      ,fr.sRequestorUserID
      ,au.sEmail as sRequestorsEmail
      ,dd.sDepartmentName as sRequestorsDepartment
      ,fr.sPrimaryContact
      ,fr.sPhoneNumber
      ,fr.iDesiredResponse
  FROM bcg_intranet.dbo.app_facilities_requests fr
  JOIN data_locations fl on fl.sLocUid = fr.sIssueLocation
  JOIN data_facilities_request_types rt on rt.id = fr.iIssueType
  JOIN app_users au on au.id = fr.sRequestorUserID
  JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber 
  ORDER BY dtRequestSubmitted ASC OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':offset', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        echo "<div class='sidemenu'>";
        echo "<p>Facilities Requests</p>";
        echo "<input type='text' placeholder='Search'>";
        echo "<hr>";
        echo "<a href='facilitiesrequestsubmit.php'><button class='btn btn-primary btn-sm'>New Request</button></a>";
        echo "</div>";
        echo "<div class='content'>";
        echo "<h2>All Requests</h2>";
        echo "<button class='btn btn-primary btn-sm'>+ Add Filter</button>";
        echo "<hr>";
        echo "<div class='requestsList'>";
        echo "<table class='userManagementTable'>";
        // <th>Facility</th>
        echo "<tr>
                <th>Requester</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Response Type</th>
                <th>Ticket Age</th>
                </tr>";
        foreach ($result as $row) {
            echo "<tr id='" . $row['id'] . "'>";
            // echo "<td>" . htmlspecialchars($row['dtRequestSubmitted']) . "</td>";
            $dateTimeString = $row['dtRequestSubmitted'];
            $dateTimeData = formatDateTime($dateTimeString);
            echo "<td>" . htmlspecialchars($row['sRequestorName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['sIssueTitle']) . "</td>";
            echo "<td><p class='badge " . getStatusString($row['iDesiredResponse']) . " '> " . getStatusString($row['iDesiredResponse']) . "</p></td>";
            echo "<td>" . getStatusString($row['iDesiredResponse']) . "</td>";
            // echo "<td>" . htmlspecialchars($dateTimeData['date']) . " | " .  htmlspecialchars($dateTimeData['time']) . "</td>";

            echo "<td>" . htmlspecialchars(getTicketAge($row['dtRequestSubmitted'])) . "</td>";

            // echo "<td><b>Type: </b> " . htmlspecialchars($row['sType']) . "</td>";
            // echo "<td rowspan='2' class='description'><b>Description: </b> " . htmlspecialchars($row['sIssueDescription']) . "</td>";
            // echo "<td rowspan='2' class='facility'><b>Facility: </b> " . htmlspecialchars($row['sName']) . " | " . htmlspecialchars($row['sIssueSubLocation']) . "</td>";
            // echo "</tr><tr class='bottomRow'>";
            // echo "<td><b> Primary Contact:  </b>" . htmlspecialchars($row['sPrimaryContact']) . "</td>";
            // echo "<td><b> Phone Number:  </b>" . htmlspecialchars($row['sPhoneNumber']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "</div>";
        $totalQuery = "SELECT COUNT(*) FROM app_facilities_requests";
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
        echo "<div class='content'>";
        echo "<p>No results found.</p>";
        echo "</div>";
    }
    include(dirname(__FILE__) . '/../components/footer.php');
    echo "</div>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<style>
    .main {
        font-size: medium;
        padding: 10px;
        display: grid;
        grid-template-columns: 15% 80%;
        gap: 5px
    }

    .sidemenu {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    /* .content {
        width: 80%;
    } */

    .requestsList {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-evenly;
    }

    table {
        border-collapse: collapse;
        width: 90%;

        /* tr:nth-child(odd) {
            border-bottom: 1px solid var(--accent);
        } */

        tr td {
            text-transform: capitalize;
            padding: 5px;
        }

        .email {
            text-transform: none;
        }
    }

    .bottomRow {
        border-bottom: 1px solid var(--accent);
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

    .facility {
        vertical-align: top;
        text-align: left;

    }

    .description {
        vertical-align: top;
        text-align: left;

    }

    .badge {
        padding: 5px;
        border-radius: 5px;
    }

    .Emergency {
        background-color: red;
        color: white;
    }

    .Urgent {
        background-color: orange;
        color: white;
    }

    .Normal {
        background-color: green;
        color: white;
    }
</style>