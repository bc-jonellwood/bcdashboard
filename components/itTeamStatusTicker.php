<?php
// Created: 2024/09/16 13:02:27
// Last modified: 2024/12/06 11:20:09

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
function abbreviateTheName($name)
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


  $html = '<div id="itTeamStatusContent" class="marquee"><div class="marquee-content">';
  // $html .= '<p>Up yours</p>';
  foreach ($data as $row) {
    $html .= '<span class="status-holder-marquee">
              <p> 
                <p class="status-' . $row['iStatus'] . '"></p>
              </p>
              <p>' .
      ($row['sPreferredName'] ? $row['sPreferredName'] : $row['sFirstName']) . ' ' . abbreviateTheName($row['sLastName']) .
      '</p>
      <p class="marquee-mini-spacer">  </p>
                  <p>' . $row['sStatusName'] . '</p>
                  <p class="marquee-spacer"> | </p>
              </span>';
  }
  $html .= '</div><div class="marquee-content">';
  // Duplicate the content for seamless scrolling
  foreach ($data as $row) {
    $html .= '<span class="status-holder-marquee">
              <p> 
                <p class="status-' . $row['iStatus'] . '"></p>
              </p>
              <p>' .
      ($row['sPreferredName'] ? $row['sPreferredName'] : $row['sFirstName']) . ' ' . abbreviateTheName($row['sLastName']) .
      '</p>
      <p class="marquee-mini-spacer">  </p>
                  <p>' . $row['sStatusName'] . '</p>
                  <p class="marquee-spacer"> | </p>
              </span>';
  }
  $html .= '</div></div>';
  echo $html;
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>

<style>
  .marquee {
    width: 100%;
    height: 50px;
    background-color: var(--accent);
    color: var(--fg);
    white-space: nowrap;
    overflow: hidden;
    box-sizing: border-box;
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    position: relative;
  }

  .marquee-content {
    display: flex;
    animation: marquee 25s linear infinite;
  }

  .status-holder-marquee {
    display: flex;
    flex-direction: row;
    align-items: center;
    font-size: medium;
  }

  .marquee p {
    margin-left: 2px !important;
    padding-left: 6px !important;
    font-size: medium;
    color: var(--bg);
  }

  .marquee-mini-spacer {
    padding-left: 3px;
    padding-right: 3px;
  }

  .marquee-spacer {
    padding-left: 10px;
    padding-right: 10px;
  }

  @keyframes marquee {
    0% {
      transform: translateX(0);
    }

    100% {
      transform: translateX(-50%);
    }
  }
</style>