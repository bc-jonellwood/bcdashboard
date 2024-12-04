<?php
// Created: 2024/09/16 13:02:27
// Last modified: 2024/12/04 11:43:54

include_once "./data/appConfig.php";

$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;


try {
  $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch (PDOException $e) {
  // echo "Connection failed: " . $e->getMessage();
}
function abbreviateName($name)
{
  return substr($name, 0, 1);
}

$sql = "WITH LatestStatus AS (
  SELECT sEmployeeId, MAX(dtLogTime) AS LatestLogTime
  FROM 
    app_user_status_log
  GROUP BY 
    sEmployeeId
)
SELECT 
  au.sFirstName,
  au.sPreferredName,
  au.sLastName,
  au.sEmployeeNumber,
  au.iStatus,
  aust.sStatusName,
  lst.LatestLogTime
FROM 
  bcg_intranet.dbo.app_users au
  INNER JOIN app_user_status_types aust 
    ON au.iStatus = aust.id
  LEFT JOIN LatestStatus lst 
    ON au.sEmployeeNumber = lst.sEmployeeId
WHERE 
  au.bIsActive = 1
  AND (au.iDepartmentNumber = '41515' OR au.iDepartmentNumber = '41514') 
ORDER BY 
  au.sFirstName ASC";

try {
  $data = [];
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    foreach ($row as $key => $value) {
      $row[$key] = $value;
    }
    array_push($data, $row);
  }


  $html = '<div id="9f8a4rbt-c1bf-4867-8399-e0dd5000458d" class="dash-card narrow">
            <div class="card-content">
              <div class="component-header">IT Team Status
                <button class="not-btn" onclick="minimizeCard(\'9f8a4rbt-c1bf-4867-8399-e0dd5000458d\')">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24">
                    <path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" />
                  </svg>
                </button>
              </div>
              <div id="itTeamStatusContent" class="card-content">
                <table class="table itTeamStatusTable">
                  <tbody>';
  foreach ($data as $row) {
    $html .= '<tr class="itTeamStatusItem">
              <td> 
                <span class="status-' . $row['iStatus'] . '"></span>
              </td>
              <td class="itTeamStatusName">' .
      ($row['sPreferredName'] ? $row['sPreferredName'] : $row['sFirstName']) . ' ' . abbreviateName($row['sLastName']) .
      '</td>
                  <td class="itTeamStatusStatus">' . $row['sStatusName'] . '</td>
                          </tr>';
  }
  $html .= '</tbody>
                </table>
            </div>
          </div>
        </div>';
  echo $html;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
