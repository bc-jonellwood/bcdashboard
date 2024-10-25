<?php
// Created: 2024/10/16 13:47:11
// Last Modified: 2024/10/25 13:29:20

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
<!-- renders the list of employees from the database for the user to select from to create a new account. Only returns employees that have access rights in the system already -->
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
                    <select name="newUserTimeApprover" id="newUserTimeApprover" class="form-control" required></select>
                    <label for="leaveApprover">Leave Approver</label>
                    <select name="newUserLeaveApprover" id="newUserLeaveApprover" class="form-control" required></select>
                    <label for="setupEquivalent">Setup Equivalent</label>
                    <select type="text" name="newUserRequestSetupEquivalent" id="setupEquivalent" class="form-control" required onchange="setEquivalentOptions(this.value)"></select>
                </div>
                <div class="form-group">
                    <label for="deskPhone">Desk Phone</label>
                    <input type="phone" name="newUserRequestDeskPhone" id="deskPhone" placeholder="123-456-7890" class="form-control">
                    <label for="emailType">Email Account</label>
                    <select name="newUserRequestEmailType" id="emailType" class="form-control" required onchange="setOfficeApplicationType(this.value)">
                        <option value="et0">No</option>
                        <option value="et1">Yes</option>
                    </select>
                    <label for="officeApplicationType" id="officeApplicationTypeLabel" class='disabled hasInfo'>Office Application Type <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em" height="1em">
                            <path d="M13,9H11V7H13M13,17H11V11H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" class="recolor" />
                        </svg></label>
                    <select name="newUserRequestOfficeApplicationType" id="officeApplicationType" class="form-control disabled" required disabled>
                        <option value="oa0" selected>None</option>
                        <option value="oa1">Web Only</option>
                        <option value="oa2">Desktop</option>
                    </select>
                    <div id="officeApplicationTypeInfo" class="info hidden">
                        <p>An email account is required for access to the office applications.</p>
                        <p>Select Web Only for users who only need access to the web versions of Office. Select Desktop for users who need installed versions of Office.</p>
                    </div>
                </div>
                <div class="form-group newUserRequestComments">
                    <textarea class="newUserRequestComments form-control" cols="40" id="newUserRequestComments" name="newUserRequestComments" placeholder="Put additional comments here, such as info for specific accounts or additional people to notify upon creation." rows="13" title="Additional Comments"></textarea>
                </div>
                <div class="form-group employeeAccessRightsHolder">
                    <label for="employeeAccessRights">Employee Access Rights</label>
                    <div id="employeeAccessRights" class="employeeAccessRights">
                        <!-- rendered dynamically by renderEmpAccessChecklist.js -->
                    </div>
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
        <div id="removeUser" class="tabContent" style="display: none;">Content for Disable User</div>
        <div id="transferUser" class="tabContent" style="display: none;">Content for Transfer User</div>
    </div>
</div>


</div>
<script>
    function setEquivalentOptions(id) {
        // alert('Your butt smells like ' + id + '!');
        var employeeAccessList = document.getElementById('employeeAccessRights');

        fetch('./API/getCurrentPermissions.php?userId=' + id)
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                var current_permissions = data[1].current_permissions;
                console.log('current_permissions');
                console.log(current_permissions);
                current_permissions.forEach(permission => {
                    console.log('permission');
                    console.log(permission);
                    const checkboxId = document.getElementById(permission.sFeatureAccessId);

                    console.log('checkboxId');
                    console.log(checkboxId);
                    // const checkbox = document.getElementById(checkboxId);
                    checkboxId.checked = true;
                    // checkbox.checked = true;
                })
                // console.log(permission);
            })
    }
</script>

<script>
    function setOfficeApplicationType(val) {
        // console.log(val)
        var officeAppTypeLabel = document.getElementById('officeApplicationTypeLabel');
        var officeAppTypeSelect = document.getElementById('officeApplicationType');
        if (val === 'et1') {
            officeAppTypeLabel.classList.remove('disabled');
            officeAppTypeSelect.classList.remove('disabled');
            officeAppTypeSelect.disabled = false;
            officeAppTypeSelect.value = 'oa1';
        } else {
            officeAppTypeLabel.classList.add('disabled');
            officeAppTypeSelect.classList.add('disabled');
            officeAppTypeSelect.disabled = true;
            officeAppTypeSelect.value = 'oa0';
        }
    }
</script>

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
    document.addEventListener('DOMContentLoaded', function() {
        try {
            var officeAppInfoLabel = document.getElementById('officeApplicationTypeLabel');
            // get svg inside the officeAppInfoLabel
            var officeAppInfoSvg = officeAppInfoLabel.querySelector('svg');
            var officeApplicationTypeInfo = document.getElementById('officeApplicationTypeInfo');
            officeAppInfoSvg.addEventListener('mouseenter', function() {
                officeApplicationTypeInfo.classList.remove('hidden');
            })
            officeAppInfoSvg.addEventListener('mouseleave', function() {
                setTimeout(function() {
                    officeApplicationTypeInfo.classList.add('hidden');
                }, 1000);
            });
        } catch (error) {
            console.error("An error occurred during initialization: ", error);
        }
    })
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
        font-size: large;
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
        color: var(--bg);
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
        color: light-dark(var(--bg), var(--bg));
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

    .employeeAccessRightsHolder {
        /* background-color: hotpink; */
        margin-top: -242px;
    }

    .disabled {
        /* pointer-events: none; */
        opacity: 0.5;
    }
</style>