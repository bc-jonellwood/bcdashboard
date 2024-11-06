<?php
// Created: 2024/10/31 11:23:38
// Last modified: 2024/11/06 11:24:31

require_once './data/appConfig.php';
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;
include_once "./components/header.php";

$userID = $_GET["id"];

echo "<div class='main'>";
include_once "./components/sidenav.php";
try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql =
        "SELECT au.id,
        au.sUserName,
        au.sEmployeeNumber,
        au.sFirstName,
        au.sLastName,
        de.sPreferredName,
        au.iDepartmentNumber,
        dd.sDepartmentName,
        au.sEmail,
        au.sMainPhoneNumber,
        au.sMainPhoneNumberLabel,
        au.bIsActive,
        au.bIsLDAP,
        au.bIsAdmin,
        au.bHideBirthday,
        au.dtLastLogin
        from app_users au
        join data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
        join data_employees de on de.iEmployeeNumber = au.sEmployeeNumber
        where au.id = :id
        ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        echo "<div class='content'>";
        echo "<form action='updateUser.php' method='post'>";
        foreach ($result as $row) {
            if ($row['id'] == $userID) {
                echo "<input type='hidden' name='id' value='" . $row['id'] . "' />";
                echo "<div class='input-group mb-3'>";
                echo "<label class='form-label' for='username'>Username:</label>";
                echo "<input class='form-control' type='text' id='username' name='username' value='" . $row['sUserName'] . "' />";

                echo "<label class='form-label' for='employeeNumber'>Employee Number:</label>";
                echo "<input class='form-control' type='text' name='employeeNumber' value='" . $row['sEmployeeNumber'] . "'/>";
                echo "</div>";
                echo "<div class='input-group mb-3'>";
                echo "<label class='form-label' for='firstName' >First Name:</label> <input class='form-control' type='text' name='firstName' value='" . $row['sFirstName'] . "' />";

                echo "<label class='form-label' for='lastName'>Last Name:</label>";
                echo "<input class='form-control' type='text' name='lastName' value='" . $row['sLastName'] . "' />";
                echo "</div>";
                echo "<div class='input-group mb-3'>";
                echo "<label class='form-label' for='departmentNumber'>Department Number:</label> ";
                include_once "./components/departmentNumberSelectElement.php";
                departmentNumberSelectElement(
                    'departmentSelect',
                    'department',
                    $row['iDepartmentNumber']
                );
                echo "</div>";
                echo "<div class='input-group mb-3'>";
                echo "<label class='form-label' for='departmentName'>Department:</label>";
                echo "<input class='form-control' type='text' name='departmentName' id='departmentName' value='" . $row['sDepartmentName'] . "' disabled />";
                echo "</div>";
                echo "<div class='input-group mb-3'>";
                echo "<label class='form-label' for='email'>Email:</label> <input class='form-control' type='email' name='email' value='" . $row['sEmail'] . "' />";
                echo "</div>";
                echo "<div class='input-group mb-3'>";
                echo "<label class='form-label' for='preferredName'>Preferred Name:</label> <input class='form-control' type='text' name='preferredName' value='" . $row['sPreferredName'] . "' />";
                echo "</div>";
                echo "<div class='input-group mb-3'>";
                echo "<label class='form-label' for='phone'>Phone Number:</label>";
                echo "<input maxlength='12' class='form-control' placeholder='Phone numbers should be in the format xxx-xxx-xxxx' type='tel' name='phone' value='" . $row['sMainPhoneNumber'] . "' oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\d{3})(\d)/, '$1-$2').replace(/(\d{3})-(\d{3})(\d)/, '$1-$2-$3');\"   />";
                echo "</div>";

                echo "<div class='input-group mb-3'>";

                if ($row['bIsActive']) {
                    echo "<label class='form-check-label' for='active'>Active: <input class='form-check-input' type='checkbox' id='active' name='active' value='" . $row['bIsActive'] . "' checked /></label>";
                } else {
                    echo "<label class='form-check-label' for='active'>Active: <input class='form-check-input' type='checkbox' id='active' name='active' value='" . $row['bIsActive'] . "' /></label>";
                }

                if ($row['bIsLDAP']) {
                    echo "<label class='form-check-label' for='ldap'>LDAP: <input class='form-check-input' type='checkbox' id='ldap' name='ldap' value='" . $row['bIsLDAP'] . "' checked /></label>";
                } else {
                    echo "<label class='form-check-label' for='ldap'>LDAP: <input class='form-check-input' type='checkbox' id='ldap' name='ldap' value='" . $row['bIsLDAP'] . "' /></label>";
                }
                if ($row['bIsAdmin']) {
                    echo "<label class='form-check-label' for='isAdmin'>Is Admin: <input class='form-check-input' type='checkbox' id='isAdmin' name='isAdmin' value='" . $row['bIsAdmin'] . "' checked /></label>";
                } else {
                    echo "<label class='form-check-label' for='isAdmin'>Is Admin: <input class='form-check-input' type='checkbox' id='isAdmin' name='isAdmin' value='" . $row['bIsAdmin'] . "' /></label>";
                }
                if ($row['bHideBirthday']) {
                    echo "<label class='form-check-label' for='hideBirthday'>Hide Birthday: <input class='form-check-input' type='checkbox' id='hideBirthday' name='hideBirthday' value='" . $row['bHideBirthday'] . "' checked /></label>";
                } else {
                    echo "<label class='form-check-label' for='hideBirthday'>Hide Birthday: <input class='form-check-input' type='checkbox' id='hideBirthday' name='hideBirthday' value='" . $row['bHideBirthday'] . "' /></label>";
                }
                echo "</div>";
                echo "<p><input class='btn btn-primary' type='submit' value='Submit' /> <button class='btn btn-danger' type='reset'>Reset</button></p>";

                echo "<p id='formExplainer'>-</p>";
                echo "</form>";
            }
        }
        echo "</form>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

include_once "./components/footer.php";

?>
<script>
    const departmentNumberSelect = document.getElementById("departmentSelect");
    const departmentName = document.getElementById("departmentName");
    const formExplainer = document.getElementById("formExplainer");

    departmentNumberSelect.addEventListener("change", () => {
        departmentName.value = departmentNumberSelect.value;
        departmentNumberSelect.parentElement.classList.add('changed')
        departmentName.parentElement.classList.add('changed')
        formExplainer.textContent = "Red background indicates a field that has been changed. Use reset button to reset all fields to their original values.";
        formExplainer.style.color = "var(--red)";
    });
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                input.parentElement.classList.add('changed');
                formExplainer.textContent = "Red background indicates a field that has been changed. Use reset button to reset all fields to their original values.";
                formExplainer.style.color = "var(--red)";
            })
        })
    })
    document.addEventListener('reset', () => {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.parentElement.classList.remove('changed');
            formExplainer.textContent = "-";
            formExplainer.style.color = "var(--bg)";
        })
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.parentElement.classList.remove('changed');
            formExplainer.textContent = "-";
            formExplainer.style.color = "var(--bg)";
        })
    })
</script>

<style>
    .main {
        /* font-size: medium; */
        padding: 10px;
        display: grid;
        grid-template-columns: 1fr;
        justify-content: center;
        /* display: grid;
        grid-template-rows: 1fr 1fr; */
    }

    .content {
        margin: 20px;
        display: flex;
        flex-wrap: wrap;
        padding: 20px;
        /* width: 50%; */

        justify-content: center;
    }

    label {
        display: block;
        padding: 5px;
        font-weight: bold;
        padding-right: 20px;
    }

    input {
        /* line-height: 1 !important; */
        border-radius: 5px;
        padding: 5px;
        border: 1px solid var(--accent);
        /* width: 100%; */
        background-color: var(--bg);
        color: var(--fg);
        /* padding-right: 20px; */

    }

    label.form-check-label:has(input[type="checkbox"]) {
        border: 1px solid var(--bg);
    }

    .input-group {
        gap: 10px;
        border: 1px solid;
        border-color: var(--bg);
    }

    #phoneHelpBlock {
        display: flex;
        justify-content: end;
    }

    #formExplainer {
        font-size: small;
        padding: 0;
        margin: 0;
        color: var(--bg);
    }

    .changed {
        border: 1px solid var(--red);
        /* padding: 5px; */
        background-color: #e53a4050;
    }
</style>