<?php
// Created: 2024/10/31 14:15:37
// Last modified: 2024/10/31 14:32:07
require_once './data/appConfig.php';
function departmentNumberSelectElement($id, $name, $current = null)
{
    $dbconf = new appConfig;
    $serverName = $dbconf->serverName;
    $database = $dbconf->database;
    $uid = $dbconf->uid;
    $pwd = $dbconf->pwd;

    try {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0", $uid, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT iDepartmentNumber, sDepartmentName FROM data_departments";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generate the select element
        echo '<select id="' . htmlspecialchars($id) . '" name="' . htmlspecialchars($name) . '" class="form-select">';
        foreach ($result as $row) {
            $selected = ($row['iDepartmentNumber'] == $current) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($row['sDepartmentName']) . '"' . $selected . '>' . htmlspecialchars($row['iDepartmentNumber']) . '</option>';
        }
        echo '</select>';
    } catch (PDOException $e) {
        // Handle connection errors
        echo "Error: " . htmlspecialchars($e->getMessage());
    } catch (Exception $e) {
        // Handle any other errors
        echo "An unexpected error occurred: " . htmlspecialchars($e->getMessage());
    }
}
