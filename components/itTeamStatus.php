<?php
// Created: 2024/09/16 13:02:27
// Last modified: 2024/11/22 15:27:49

?>

<script>
    function getItTeamStatus() {
        fetch("./API/getItTeamStatusForView.php")
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
    }
    getItTeamStatus();
</script>
<!-- function getItTeamStatus()
{
    include "dbheader.php";
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
  au.sFirstName ASC;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<div id='9f8a4rbt-c1bf-4867-8399-e0dd5000458d' class='dash-card narrow short'>";
    echo "<div class='card-content'>";
    echo "<div class='component-header'>IT Team Status <button class='not-btn' onclick='minimizeCard(\"9f8a4rbt-c1bf-4867-8399-e0dd5000458d\")'>";
    echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' class='recolor' width='24' height='24'>";
    echo "<path d='M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z' /></svg>";
    echo "</button></div>";
    echo "<div id='itTeamStatusContent' class='card-content'>";
    foreach ($result as $row) {
        $dateTimeString = $row['LatestLogTime'];
        $dateTime = new DateTime($dateTimeString);
        $dateTime->setTimezone(new DateTimeZone('America/New_York'));
        $formattedDateTime = $dateTime->format('m/d/Y h:i A');
        echo "<div class='itTeamStatusItem'>";
        echo "<div class='itTeamStatusName'>" . $row['sFirstName'] . " " . $row['sPreferredName'] . " " . $row['sLastName'] . "</div>";
        echo "<div class='itTeamStatusNumber'>" . $row['sEmployeeNumber'] . "</div>";
        echo "<div class='itTeamStatusStatus'>" . $row['sStatusName'] . "</div>";
        echo "<div class='itTeamStatusTime'>" . $formattedDateTime . "</div>";
        echo "</div>";
    }
    echo "</div></div></div>";
} -->