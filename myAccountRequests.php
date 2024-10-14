<?php

// Created: 2020/10/09 11:33:11
// Last modified: 2024/10/14 14:29:21
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


<script src="./functions/renderEmpList.js"></script>
<script src="./functions/getCurrentPermission.js"></script>
<script src="./functions/getFeatureAccessList.js"></script>
<script>
    // renderAllEmployeesSelect()
    renderAllEmployeesList();
</script>
<script>
    function filterFunction() {
        const ulElement = document.getElementById("employee-list");
        ulElement.classList.remove("hidden");
        console.log('starting filter');
        var input, filter, list, items, i;

        input = document.getElementById("empInput");
        filter = input.value.toUpperCase();
        list = document.getElementById("employee-list");
        items = list.getElementsByTagName("li");

        for (i = 0; i < items.length; i++) {
            const item = items[i];
            const txtValue = item.textContent || item.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                item.style.display = "";
            } else {
                item.style.display = "none";

            }
        }
    }
</script>

<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <div class="form-holder">
            <label class="form-label small">Select an employee to submit an account request for</label>
            <input type="text" placeholder="...search" id='empInput' onkeyup='filterFunction()'>
            <ul id="employee-list" class="list-group list-group-flush hidden"></ul>
        </div>
        <div class="selected-holder" id="selected-holder">
        </div>
    </div>
    <div class="content">
        <div class="current-access">
            <p>Current Access</p>
            <div id="currentAccessList">
            </div>
        </div>
    </div>
    <div id="accessOptions" class="content">
        <p>Access Options</p>
        <div id="featureAccessList">
        </div>
    </div>
</div>

<?php include "./components/footer.php" ?>

<script>
    function validateAndSubmitForm() {
        const employeeID = document.getElementById("employees").value;
        const form = document.getElementById("featureAccessForm");
        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "employeeID";
        hiddenInput.value = employeeID;
        form.appendChild(hiddenInput);
        if (employeeID === "") {
            alert("Please select an employee");
        }

        if (employeeID !== "") {
            document.getElementById("form").submit();
        }
    }
</script>




<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        display: grid;
        grid-template-columns: 20% 30% 30%;
        gap: 1ex;
    }

    .content,
    .form-holder {
        margin: 20px;
        padding: 10px;
    }

    .capitalize {
        text-transform: capitalize;
    }

    #employee-list {
        list-style: none;
        font-size: smaller;
    }

    .hidden {
        display: none;
    }

    #empInput {
        width: 90%;
    }
</style>


<!-- 
<select class="form-select" id="employees" onchange="getCurrentPermissions(this.value)">
    <option selected="">Select an employee</option>
    <option value="0A202501-5148-49F0-A42D-ABB3C5AD82EA">EMILY ALBER (8414)</option>
    <option value="C5A2123D-19C1-41D3-A788-A687F999E48F">CATHERINE LECKIE (8396)</option>
</select> -->