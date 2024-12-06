<?php
// Created: 2024/12/06 12:10:10
// Last modified: 2024/12/06 12:43:14

require_once './data/appConfig.php';
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
    echo "Connection failed: " . $e->getMessage();
}


$sql = "SELECT * FROM data_team_tuesday WHERE GETDATE() BETWEEN dtPublishDate AND dtExpireDate";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($data) > 0) {
        echo '<div id="4c2fe295-7d3d-4a0f-97b6-964930142902" class="dash-card medWide">';
        echo '<div class="card-content">
            <div class="component-header">Team Tuesday <button class="not-btn" onclick="minimizeCard(\'4c2fe295-7d3d-4a0f-97b6-964930142902\')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24"><path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" /></svg></button></div>
            <div id="teamTuesday" class="card-content">';
        foreach ($data as $row) {
            echo '<div>';
            echo '<img src="' . $row['sPhotoPath'] . '" alt="photo" class="teamTuesdayPhoto" />';
            echo '<h4>' . strtolower($row['sTitle']) . '</h4>';
            echo '<p class="question">Department / Role</p>';
            echo '<p class="answer">' . $row['sDepartment'] . '</p>';
            echo '<p class="question">Describe yourself in two words</p>';
            echo '<p class="answer">' . $row['sDescribeYourself'] . '</p>';
            echo '<p class="question">What’s your favorite hobby?</p>';
            echo '<p class="answer">' . $row['sFavoriteHobby'] . '</p>';
            echo '<p class="question">What’s your favorite thing to do outside of work?</p>';
            echo '<p class="answer">' . $row['sFavoriteOutsideInterest'] . '</p>';
            echo '<p class="question">What’s your favorite show to binge watch?</p>';
            echo '<p class="answer">' . $row['sFavoriteShow'] . '</p>';
            echo '<p class="question">What’s your favorite vacation spot</p>';
            echo '<p class="answer">' . $row['sFavoriteVacation'] . '</p>';
            echo '<p class="question">What is something unique about yourself?</p>';
            echo '<p class="answer">' . $row['sSomethingUnique'] . '</p>';
            echo '</div>';
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<style>
    .teamTuesdayPhoto {
        width: 200px;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid var(--accent);
        border-radius: 100%;
    }

    #teamTuesday {
        h4 {
            text-transform: capitalize;
            font-weight: bold;
            text-align: center;
            width: 100%;
            padding-top: 5px;
            padding-bottom: 4px;
            border-bottom: 1px solid var(--accent);
        }

        .question {
            font-weight: bolder;
        }

        .answer {
            font-style: italic;
        }
    }
</style>