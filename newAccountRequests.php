<?php
// Created: 2024/10/16 13:47:11
// Last Modified: 2024/10/18 13:42:28

include "./components/header.php";

?>
<!-- <script src="./functions/addBlankSelectOption.js"></script> -->
<!-- <script src="./data/accountRequestLocationData.js"></script> -->
<!-- <script src="./functions/renderRequestLocationDataSelectOptions.js"></script> -->

<!-- renders the list of employees from the database for the user to select from to create a new account -->
<script src="./functions/renderEmpListNewRequest.js"></script>
<!-- allows the filtering of the employees list as the user types-->
<script src="./functions/employeeSelectFilterFunction.js"></script>
<!-- renders the checkboxes for the employees that the user has access to -->
<script src="./functions/renderEmpAccessChecklist.js"></script>
<!-- renders the select element for the time approver for the new account request (both leave and time based on parms passed in)-->
<script src="./functions/renderTimeApproverSelectElement.js"></script>
<!-- renders the list of employees from the database for the user to select from to create a new account -->
<script src="./functions/renderEmpListNewRequestSetupEquivalent.js"></script>
<!-- script to validate the inputs then submit to the database -->
<script src="./functions/submitNewAccountRequest.js"></script>
<div class="main">
    <?php include "./components/sidenav.php" ?>

    <div class="tabs">
        <div class="tab" onclick="switchTab(event, 'newUser')">New User</div>
        <div class="tab" onclick="switchTab(event, 'returningUser')">Returning User</div>
        <div class="tab" onclick="switchTab(event, 'changeUser')">Change User</div>
        <div class="tab" onclick="switchTab(event, 'removeUser')">Remove User</div>
        <div class="tab" onclick="switchTab(event, 'transferUser')">Transfer User</div>
    </div>

    <div class="content">
        <div id="newUser" class="tabContent" style="display: none;">
            <!-- <h2>New User</h2> -->
            <div class="form-group">
                <p class="disclaimer" id="disclaimer">An employee must be in this list to submit an account request. If they are not, please check with HR. If they were "just" entered, the data might be syncing across all our systems. Please try again in a 15-20 minutes.</p>
                <label class="form-label small" id="selectEmpLabel">Select an employee to submit an account request for</label>
                <input type="text" placeholder="...search" id="empInput" onkeyup="filterFunction('empInput', 'employee-list')">
                <ul id="employee-list" class="list-group list-group-flush hidden"></ul>
                <div class="selected-holder" id="selected-holder"></div>
            </div>
            <div class="form-group hidden top-border" id="newUserRequestForm">
                <div class="form-group">

                    <label for="timeApprover">Time Approver</label>
                    <select name="newUserTimeApprover" id="1023" class="form-control" required></select>
                    <label for="leaveApprover">Leave Approver</label>
                    <select name="newUserLeaveApprover" id="1024" class="form-control" required></select>
                    <label for="setupEquivalent">Setup Equivalent</label>
                    <select type="text" name="newUserRequestSetupEquivalent" id="setupEquivalent" class="form-control" required></select>
                </div>
                <div class="form-group">
                    <label for="computerAssetNumber">Computer Asset Number</label>
                    <input type="text" name="newUserRequestComputerAssetNumber" id="computerAssetNumber" class="form-control">
                    <label for="deskPhone">Desk Phone</label>
                    <input type="phone" name="newUserRequestDeskPhone" id="deskPhone" placeholder="123-456-7890" class="form-control">
                    <label for="emailType">Email Type</label>
                    <select name="newUserRequestEmailType" id="emailType" class="form-control" required>
                        <option value="et0">None</option>
                        <option value="etg1">G1</option>
                        <option value="etg3">G3</option>
                    </select>
                    <!-- <label for="monitorOneAssetNumber">Monitor One Asset Number</label>
                    <input type="text" name="newUserRequestMonitorOneAssetNumber" id="monitorOneAssetNumber" class="form-control">
                    <label for="monitorTwoAssetNumber">Monitor Two Asset Number</label>
                    <input type="text" name="newUserRequestMonitorTwoAssetNumber" id="monitorTwoAssetNumber" class="form-control">
                    <label for="printerAssetNumber">Printer Asset Number</label>
                    <input type="text" name="newUserRequestPrinterAssetNumber" id="printerAssetNumber" class="form-control"> -->
                </div>
                <div class="form-group">
                    <label for="employeeAccessRights">Employee Access Rights</label>
                    <div id="employeeAccessRights" class="employeeAccessRights">
                        <!-- rendered dynamically by renderEmpAccessChecklist.js -->
                    </div>
                </div>
                <div class="form-group newUserRequestComments">
                    <textarea class="newUserRequestComments form-control" cols="40" id="newUserRequestComments" name="newUserRequestComments" placeholder="Put additional comments here, such as info for specific accounts or additional people to notify upon creation." rows="5" title="Additional Comments"></textarea>
                </div>

                <div class="form-group dress-right">
                    <button type="button" class="btn btn-primary" id="newUserRequestSubmit" onclick="submitNewAccountRequest()">Submit</button>
                </div>
            </div>
            <div class="errorMessage" id="errorMessage">

            </div>
        </div>

        <div id="returningUser" class="tabContent" style="display: none;">Please use the "New User" tab as all the information requried is the same. Thanks</div>
        <div id="changeUser" class="tabContent" style="display: none;">Content for Change User</div>
        <div id="removeUser" class="tabContent" style="display: none;">Content for Remove User</div>
        <div id="transferUser" class="tabContent" style="display: none;">Content for Transfer User</div>
    </div>
</div>


</div>


<script>
    function switchTab(event, tabId) {
        try {
            // Hide all tab contents
            const tabContents = document.getElementsByClassName('tabContent');
            for (let i = 0; i < tabContents.length; i++) {
                tabContents[i].style.display = 'none';
            }

            // Remove active class from all tabs
            const tabs = document.getElementsByClassName('tab');
            for (let i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }

            // Show the selected tab content
            document.getElementById(tabId).style.display = 'block';

            // Mark the clicked tab as active
            event.currentTarget.classList.add('active');
        } catch (error) {
            console.error("An error occurred while switching tabs: ", error);
        }
    }

    // Initialize the first tab as active
    document.addEventListener('DOMContentLoaded', function() {
        try {
            switchTab({
                currentTarget: document.getElementsByClassName('tab')[0]
            }, 'newUser');
        } catch (error) {
            console.error("An error occurred during initialization: ", error);
        }
    });
</script>
<script>
    function maskInput() {
        const element = document.getElementById("deskPhone");
        const maskOptions = {
            mask: "000-000-0000",
        };
        const mask = new IMask(element, maskOptions);
    }
    maskInput();
</script>
<script>
    generateAccessChecklist("employeeAccessRights")
    renderTimeApproverSelectElement('1023');
    renderTimeApproverSelectElement('1024');
    renderSetupEqSelect();
</script>
<style>
    .main {
        grid-template-columns: 10% 90%;
    }

    .tabs {
        width: 200px;
        background-color: var(--bg);
        padding: 10px;
        /* border-right: 1px solid var(--fg); */
    }

    .tab {
        padding: 10px;
        cursor: pointer;
        border: 1px solid transparent;
        border-radius: 4px;
        margin-bottom: 5px;
        text-align: center;
    }

    .tab:hover {
        background-color: #ddd;
    }

    .active {
        background-color: var(--accent);
        color: white;
        border: 1px solid #4CAF50;
    }

    .content {
        padding: 20px;
        flex-grow: 1;
    }

    .top-border {
        border-top: 1px solid var(--accent);
    }

    .bottom-border {
        border-bottom: 1px solid var(--accent);
    }

    .capitalize {
        text-transform: capitalize;
    }

    #employee-list {
        list-style: none;
        font-size: smaller;
    }

    .selected-holder {
        margin-bottom: 10px;

        p {
            margin-bottom: 0 !important;
        }

        button {
            margin-bottom: 10px;
        }
    }

    .selected-holder>span {
        /* display: flex; */
        font-size: large;
        text-transform: capitalize;
        /* flex-direction: column; */
        gap: 10px;
        padding-left: 10px;
    }

    .newUserRequestFormShow {
        margin-top: 10px;
        padding-top: 10px;
        display: grid;
        grid-template-columns: 1fr 2fr 2fr;
        max-width: 90%;
        gap: 20px;
    }


    .access-rights-checklist {
        list-style: none;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 5px;
        font-size: 20px;
        text-transform: capitalize;
        min-width: 40%;

        label {
            padding-left: 5px;
            padding-right: 5px;
        }
    }



    label:has(> input[type='checkbox']:checked) {
        background-color: var(--accent);
        border-radius: 7px;
        color: light-dark(var(--bg), var(--fg));
    }

    .newUserRequestComments {
        grid-column-start: 1;
        grid-column-end: 3;
    }

    .errorMessage {
        margin-top: 20px;
        padding: 10px;
        border-radius: 7px;
    }

    .activeError {
        border: 1px solid var(--light-fire);
        background-color: var(--dark-fire);
        color: var(--light-fire);
    }
</style>