<?php
// Created: 2024/10/31 11:23:38
// Last modified: 2024/11/05 16:34:17
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['showAll'])) {
    $_SESSION['showAll'] = false;
}
require_once './data/appConfig.php';
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;
include_once "./components/header.php";

include_once "./components/sidenav.php";
echo "<div class='main'>";
// echo $_SESSION['showAll'];
try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $limit = 100;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    // echo "Connected successfully";
    if (!isset($_SESSION['showAll'])) {
        $_SESSION['showAll'] = false;
        echo $_SESSION['showAll'];
    };
    if (isset($_SESSION['showAll']) && $_SESSION['showAll'] == false) {
        $sql = "SELECT au.id,
             au.sEmployeeNumber,
             au.sFirstName,
             au.sLastName,
             dd.sDepartmentName
             from app_users au
             join data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
             where bIsActive = 1
             order by au.sLastName
             OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";
    } else {
        $sql = "SELECT au.id,
             au.sEmployeeNumber,
             au.sFirstName,
             au.sLastName,
             dd.sDepartmentName
             from app_users au
             join data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
             order by au.sLastName
             OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";
    }
    // $sql =
    //     "SELECT au.id,
    //         au.sEmployeeNumber,
    //         au.sFirstName,
    //         au.sLastName,
    //         dd.sDepartmentName
    //         from app_users au
    //         join data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
    //         WHERE 1=1" .
    //     (isset($_SESSION['showAll']) && $_SESSION['showAll'] ? "" : " AND au.bIsActive = 1") . "
    //         order by au.sLastName
    //         OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";
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

        echo "<div class='form-check form-switch options-switcher'>
                <input class='form-check-input' type='checkbox' id='showAll' onclick='toggleShowAll()'>
                <label class='form-check-label' for='showAll' id='showAllLabel'></label>
            </div>";
        echo "<div class='content'>";
        echo "<div class='employeeList'>";
        echo "<table class='userManagementTable'>";

        foreach ($result as $row) {
            echo "<tr onclick='getUser(" . json_encode($row['id']) . ")' data-id='" . $row['id'] . "'>";
            echo "<td colspan='2' class='empName'>" . htmlspecialchars(strtolower($row['sFirstName'])) . ' ' . htmlspecialchars(strtolower($row['sLastName'])) . "</td>";
            echo "</tr>";
            echo "<tr onclick='getUser(" . json_encode($row['id']) . ")' data-id='" . $row['id'] . "'>";
            echo "<td class='preview'>" . htmlspecialchars($row['sDepartmentName']) . "</td>";
            echo "<td class='preview'># " . htmlspecialchars($row['sEmployeeNumber']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // echo "</div>";
        if (isset($_SESSION['showAll']) && $_SESSION['showAll'] == 'false') {
            $totalQuery = "SELECT COUNT(*) FROM app_users where bIsActive = 1";
        } else {
            $totalQuery = "SELECT COUNT(*) FROM app_users";
        }
        $totalStmt = $conn->prepare($totalQuery);
        $totalStmt->execute();
        $totalRecords = $totalStmt->fetchColumn();
        $totalPages = ceil($totalRecords / $limit);

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $startPage = max(1, $currentPage - 1);
        $endPage = min($totalPages, $currentPage + 1);

        echo "<div class='pagination'>";
        for ($i = $startPage; $i <= $endPage; $i++) {
            $activeClass = ($i === $currentPage) ? 'class="active"' : '';
            echo "<a href='?page=$i' $activeClass>$i</a> ";
        }
        echo "</div>";
        echo "</div>";
        echo "<div id='editUserPanel' class='editUserPanel'></div>";
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

    function getUser(id) {
        fetch('./API/getSingleUserById.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data.id);
                // if (data.length > 0) {
                let formHTML = "<div>";
                formHTML += "<form action='updateUser.php' method='post'>";
                formHTML += `
                        <input type='hidden' name='id' value='${data.id}' />
                        <div class='input-group mb-3 status-holder'><p class='form-label acct_${data.bIsActive}'>User Account Status: </p><p class='accountStatus'>${data.bIsActive === "1" ? "ACTIVE" : "INACTIVE"}</p></div>
                        <div class='input-group mb-3'>
                            <label class='form-label' for='username'>Username:</label>
                            <input class='form-control' type='text' id='username' name='username' value='${data.sUserName}' disabled/>

                            <label class='form-label' for='employeeNumber'>Employee Number:</label>
                            <input class='form-control' type='text' name='employeeNumber' value='${data.sEmployeeNumber}' disabled/>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='form-label' for='firstName'>First Name:</label>
                            <input class='form-control' type='text' name='firstName' value='${data.sFirstName}' ? '${data.sFirstName}' : ""}' disabled/>
                        
                            <label class='form-label' for='lastName'>Last Name:</label>
                            <input class='form-control' type='text' name='lastName' value='${data.sLastName}' ? '${data.sLastName}' : ""}' disabled/>
                        </div>
                        
                        <div class='input-group mb-3'>
                            <label class='form-label' for='departmentName'>Department:</label>
                            <input class='form-control' type='text' name='departmentName' id='departmentName' value='${data.sDepartmentName}' ? '${data.sDepartmentName}' : "' disabled />
                        
                            <label class='form-label' for='email'>Email:</label>
                            <input class='form-control' type='email' name='email' value='${data.sEmail}' ? '${data.sEmail}' : ""}' disabled/>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='form-label' for='preferredName'>Preferred Name:</label>
                            <input class='form-control' type='text' name='preferredName' value='${data.sPreferredName}' ? '${data.sPreferredName}' : ""}' />
                        
                            <label class='form-label' for='phone'>Phone Number:</label>
                            <input maxlength='12' class='form-control' placeholder='Phone numbers should be in the format xxx-xxx-xxxx' type='tel' name='phone' value='${data.sMainPhoneNumber}' ? '${data.sMainPhoneNumber}' : ""}'  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\\d{3})(\\d)/, '$1-$2').replace(/(\\d{3})-(\\d{3})(\\d)/, '$1-$2-$3');" disabled/>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='form-check-label' for='active'>Active: <input class='form-check-input' type='checkbox' id='active' name='active' value='${data.bIsActive}' ${data.bIsActive ? "checked" : ""} /></label>
                            <label class='form-check-label' for='ldap'>LDAP: <input class='form-check-input' type='checkbox' id='ldap' name='ldap' value='${data.bIsLDAP}' ${data.bIsLDAP ? "checked" : ""} /></label>
                            <label class='form-check-label' for='isAdmin'>Is Admin: <input class='form-check-input' type='checkbox' id='isAdmin' name='isAdmin' value='${data.bIsAdmin}' ${data.bIsAdmin ? "checked" : ""} /></label>
                            <label class='form-check-label' for='hideBirthday'>Hide Birthday: <input class='form-check-input' type='checkbox' id='hideBirthday' name='hideBirthday' value='${data.bHideBirthday}' ${data.bHideBirthday ? "checked" : ""} /></label>
                        </div>
                        <p><input class='btn btn-primary' type='submit' value='Submit' /> <button class='btn btn-danger' type='reset'>Reset</button></p>
                        <p id='formExplainer'>-</p>
                        </form>
                        </div>
                    `
                var target = document.getElementById('editUserPanel');
                target.innerHTML = formHTML;
                // console.log(formHTML);
                setActive(id);
                //addFuncsToForm();
                // }
            })
    }
</script>
<script>
    function addFuncsToForm() {
        console.log("Setting fire to the form");
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
    }
    // takes the value of id as a param and then finds all <tr> elements with dataset.id = id and adds the class active to it. It also removes the active class from all other <tr> elements
    function setActive(id) {
        const trs = document.querySelectorAll('tr');

        trs.forEach(tr => {
            if (tr.dataset.id == id) {
                tr.classList.add('active');
            } else {
                tr.classList.remove('active');
            }
        })
    }

    async function toggleShowAll() {
        console.log('toggling ShowAll');
        var showAll = localStorage.getItem('bc-showAll');
        // if (showAll == null) {
        //     localStorage.setItem('bc-showAll', 'false');
        // }
        if (showAll == 'true') {
            localStorage.setItem('bc-showAll', 'false');
            document.getElementById('showAllLabel').textContent = 'Showing Active Only';
            await fetch('./API/setShowAll.php?showAll=false')
                .then(response => response.json())
                .then(data => {
                    // console.log('data dot success', data[0].success);
                    if (data[0].success == 'true') {
                        window.location.reload()
                    }
                })
        } else {
            localStorage.setItem('bc-showAll', 'true');
            document.getElementById('showAllLabel').textContent = 'Showing All';
            document.getElementById('showAll').checked = true;
            await fetch('./API/setShowAll.php?showAll=true')
                .then(response => response.json())
                .then(data => {
                    // console.log('data dot success', data[0].success);
                    if (data[0].success == 'true') {
                        window.location.reload()
                    }
                })
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        var showAll = localStorage.getItem('bc-showAll');
        // console.log('showAll', showAll);
        if (!showAll) {
            console.log('No show all');
            //localStorage.setItem('bc-showAll', 'false');
            //document.getElementById('showAllLabel').textContent = 'Showing Only Active';
            // send fetch requst to setShowAll.php to set the session variable
            //fetch('./API/setShowAll.php?showAll=false');
        } else {
            console.log('showAll', showAll);
        }
        // else if (showAll == 'true') {
        // document.getElementById('showAllLabel').textContent = 'Showing All';
        //  document.getElementById('showAll').checked = true;
        // send fetch requst to setShowAll.php to set the session variable
        // fetch('./API/setShowAll.php?showAll=true');
        // } else if (showAll == 'false') {
        // document.getElementById('showAll').checked = false;
        // document.getElementById('showAllLabel').textContent = 'Showing Only Active';
        //fetch('./API/setShowAll.php?showAll=false');
        // }
    })
</script>
<style>
    /* body {
        max-height: 99vh;
    } */

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

    .options-switcher {
        display: flex;
        flex-wrap: wrap;
        /* justify-content: space-between; */
        align-items: center;
        margin: 20px 0;
        padding-left: 3%;
    }

    table {
        border-collapse: collapse;
        width: 110%;

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

    .content {
        display: grid;
        grid-template-columns: 15% 85%;
        padding: 10px;
    }

    .status-holder {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        font-size: larger;
        font-weight: bold;
        text-align: center;
        margin: 10px;
        padding: 10px;
        border: 1px solid var(--accent);
        border-radius: 5px;
    }

    .employeeList {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        max-height: 99vh;
        overflow-y: hidden;
        scrollbar-gutter: stable both-edges;
    }

    .employeeList:hover {
        overflow-y: scroll;
    }

    .empName {
        font-weight: bold;
        font-size: large;
        border-bottom: none !important;
    }

    .preview {
        font-size: smaller;
        filter: brightness(0.8);
    }

    .editUserPanel {
        /* box-shadow: -10px 0px 11px -6px rgba(0, 0, 0, 0.75); */
        box-shadow: -10px 0px 11px -6px var(--accent);
        padding: 20px;
    }

    /* .main {
        
        padding: 10px;
        display: grid;
        grid-template-columns: 1fr;
        justify-content: center;
        
    }

    .content {
        margin: 20px;
        display: flex;
        flex-wrap: wrap;
        padding: 20px;
        

        justify-content: center;
    } */

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

    tr.active {
        background-color: var(--fg);
        color: var(--bg);
    }

    .acct_1+p {
        color: green;
    }

    .acct_0+p {
        color: red;
    }
</style>