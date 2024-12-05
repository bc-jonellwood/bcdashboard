<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/04 13:46:43
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

// $sql = "SELECT *
// FROM `emp_ref`
// WHERE seperation_date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
//                           AND DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY)
// ORDER BY seperation_date DESC";
$data = [];
$sql = "SELECT e.sFirstName, e.sLastName, e.sMainPhoneNumber, d.sDepartmentName, e.dtStartDate FROM data_employees e
JOIN data_departments d ON e.iDepartmentNumber = d.iDepartmentNumber
WHERE dtStartDate BETWEEN DATEADD(DAY, -21, CAST(GETDATE() AS DATE))
                           AND DATEADD(DAY, 21, CAST(GETDATE() AS DATE))
ORDER BY dtStartDate DESC";


try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($data) > 0) {
        echo '<div id="a05ca0c4-c518-4692-a363-093a7a5f5af6" class="dash-card">';
        echo '<div class="card-content">
            <div class="component-header">Welome our new team members <button class="not-btn" onclick="minimizeCard(\'a05ca0c4-c518-4692-a363-093a7a5f5af6\')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24"><path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" /></svg></button></div>
            <div id="recentHiredContent" class="card-content">
                <div class="carousel">
                    <div class="carousel__nav">
                        <span id="moveLeft" class="carousel__arrow">
                            <svg class="carousel__icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                            </svg>
                        </span>
                        <span id="moveRight" class="carousel__arrow" >
                            <svg class="carousel__icon"  width="24" height="24" viewBox="0 0 24 24">
                                <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                        </svg>    
                    </span>
                </div> 
             
            ';
        // echo '<table class="table"><tbody><tr><th>Name</th><th>Department</th><th>Start Date</th></tr>';
        $i = 229;
        foreach ($data as $row) {
            echo '<div class="carousel-item carousel-item--' . $i . '">';
            echo '<div class="carousel-item__image">';
            echo '<img src="http://picsum.photos/' . $i . '/250" alt="not kitty">';
            echo '</div>';
            echo '<div class="carousel-item__info">';
            echo '<div class="carousel-item__container">';
            echo '<h2 class="carousel-item__subtitle">' . strtolower($row['sFirstName'] . ' ' . $row['sLastName']) . '</h2>';
            echo '<h1 class="carousel-item__title">' . strtolower($row['sDepartmentName']) . '</h1>';
            echo '<p class="carousel-item__description"> Joined our team on ' . date('m/d/Y', strtotime($row['dtStartDate'])) . '</p>';

            // echo '<p class="name">' . strtolower($row['sDepartmentName']) . '</p>';
            // echo '<p class="date"> Joined our team on ' . date('m/d/Y', strtotime($row['dtStartDate'])) . '</p>';
            echo '<a href="#" class="carousel-item__btn">View Profile</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            $i++;
        }
        echo '
            </div>
            </div>
            </div>
            </div>';
    } else {
        echo '<div id="a05ca0c4-c518-4692-a363-093a7a5f5af6" class="dash-card">';
        echo '<div class="card-content">';
        echo '<div class="component-header">Recent Hires <button class="not-btn" onclick="minimizeCard(\'a05ca0c4-c518-4692-a363-093a7a5f5af6\')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24"><path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" /></svg></button></div>';
        echo '<p>No hires within the 14 day window.</p>';
        echo '</div>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// header('Content-Type: application/json');
// echo json_encode($data);


// echo '<img src="http://placebear.com/250/250" alt="not kitty">';
// echo '<div class="contact-info">
//                 <p class="phone">Phone: ' . $row['sMainPhoneNumber'] . '</p> <p class="email">Email: ' . strtolower($row['sFirstName'] . '.' . $row['sLastName'] . '@berkeleycountysc.gov') . '</p>';
// echo '</div>';
// echo '</div>';
?>
<style>
    /* .carousel-item {
        img {
            height: 250px;
            width: 250px;
            border: 1px solid var(--fg);
            border-radius: 100%;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 2em;
        }
    } */
</style>