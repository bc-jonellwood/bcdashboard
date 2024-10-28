<?php

// Created: 2020/10/09 11:33:11
// Last modified: 2024/10/28 14:59:17
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
    // pass in the id of the select target element as a param
    renderAllEmployeesList("employee-list");
    // renderAllEmployeesAsList("employee-as-list");
</script>
<script>
    function filterFunction(inputId, listId) {
        const ulElement = document.getElementById(listId);
        ulElement.classList.remove("hidden");
        // console.log('starting filter');
        var input, filter, list, items, i;

        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        list = document.getElementById(listId);
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
            <input type="text" placeholder="...search" id="empInput" onkeyup="filterFunction('empInput', 'employee-list')">
            <ul id="employee-list" class="list-group list-group-flush hidden"></ul>
            <div class="selected-holder" id="selected-holder"></div>
        </div>
        <!-- <div class="form-holder">
            <label class="form-label small">For new accounts, base access on: </label>
            <input type="text" placeholder="...search" id="empInput-2" onkeyup="filterFunction('empInput-2', 'employee-as-list')">
            <ul id="employee-as-list" class="list-group list-group-flush hidden"></ul>
        </div> -->
        <div>
            <div class="selected-holder" id="selected-as-holder"></div>
        </div>
    </div>
    <div class="content">
        <div class="current-access">
            <p>Current Access</p>
            <div id="currentAccessList">
            </div>
        </div>
    </div>

    <div class="content">
        <div id="accessOptions">
            <p>Pending Changes</p>
            <div id="pendingChangesList">
            </div>
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

    #employee-list,
    #employee-as-list {
        list-style: none;
        font-size: smaller;
    }

    .hidden {
        display: none;
    }

    #empInput,
    #empInput-2 {
        width: 90%;
    }

    .selected-holder>div {
        display: flex;
        font-size: large;
        text-transform: capitalize;
        margin-bottom: 10px;
    }

    .input-holder {
        display: grid;
        grid-template-columns: 10% 45% 15% 15%;
        gap: 1px;
        justify-content: space-between;
        margin-bottom: 0.25rem;
        padding-left: 5px !important;
        font-size: large;
    }

    /* Initial styles */
    #pendingChangesList {
        /* border: 1px solid #ccc; */
        padding: 10px;
        min-height: 50px;
        width: 90%;
        margin-top: 20px;
        position: relative;

        div {
            grid-template-columns: 90% 10%;
        }
    }

    /* Animation for sliding */
    @keyframes slideToRight {
        0% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(-20%);
        }

        90% {
            transform: translateX(5%);
        }

        100% {
            transform: translateX(0);
        }
    }



    .slide-element {
        animation: slideToRight .5s forwards;
        /* position: absolute; */
        /* Allows it to move without affecting layout */
    }
</style>


<!-- 
<select class="form-select" id="employees" onchange="getCurrentPermissions(this.value)">
    <option selected="">Select an employee</option>
    <option value="0A202501-5148-49F0-A42D-ABB3C5AD82EA">EMILY ALBER (8414)</option>
    <option value="C5A2123D-19C1-41D3-A788-A687F999E48F">CATHERINE LECKIE (8396)</option>
</select> -->