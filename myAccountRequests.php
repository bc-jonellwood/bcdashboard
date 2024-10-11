<?php

// Created: 2020/10/09 11:33:11
// Last modified: 2024/10/11 15:47:15
include "./components/header.php";
?>
<script>
    // function addBlankSelectOption() {
    //     const selectElement = document.getElementById("employees");
    //     selectElement.innerHTML += `
    // <option selected>Select an employee</option>
    // `
    // }
</script>

<script src="./functions/renderEmpSelectEl.js"></script>
<script src="./functions/getCurrentPermission.js"></script>
<script>
    renderAllEmployeesSelect()
</script>

<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <div class="form-holder">
            <label class="form-label small">Select an employee to submit an account request for</label>
            <select class="form-select" id="employees" onchange="getCurrentPermissions(this.value)">
            </select>
        </div>
    </div>
    <div class="content">
        <div class="current-access">
            <p>Current Access</p>
        </div>
    </div>
</div>

<?php include "./components/footer.php" ?>

<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        display: grid;
        grid-template-columns: 20% 30% 30%;
        gap: 1ex;
    }

    .form-holder {
        margin: 20px;
        padding: 10px;
    }
</style>