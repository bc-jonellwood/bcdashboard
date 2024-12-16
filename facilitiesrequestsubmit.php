<?php
// Created: 2024/11/15 11:22:08
// Last Modified: 2024/12/13 14:59:44

include "./components/header.php";

?>


<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <form id="newFacilitiesRequestForm" method="post" action="API/addNewFacilitiesRequestToDatabase.php">
            <div class="d-flex flex-row justify-content-between gap-2 mt-2">
                <label for="issueTitle">Tell us briefly what your request is</label>
                <input name="issueTitle" id="issueTitle" class="form-control" rows="3" required></textarea>
                <label for="issueType" class="hidden">Issue Type</label>
                <select name="issueType" id="issueType" class="form-control hidden" required></select>
            </div>
            <div class="d-flex flex-row justify-content-between gap-2 mt-2">
                <label for="issueDescription">Describe the request in detail</label>
                <textarea name="issueDescription" id="issueDescription" class="form-control" rows="3" required></textarea>
            </div>
            <div class="d-flex flex-row justify-content-between gap-2 mt-2">
                <label for="issueLocation">Select the area that best matches the location of your request</label>
                <select name="issueLocation" id="issueLocation" class="form-control" required></select>
            </div>
            <div class="d-flex flex-row justify-content-between gap-2 mt-2">
                <label for="issueSubLocation">Provide any additional details to help us locate you quickly.</label>
                <input name="issueSubLocation" id="issueSubLocation" class="form-control" rows="3"></input>
            </div>
            <div class="d-flex flex-row justify-content-between gap-2 mt-2">
                <label for="requestorName">Submitted By</label>
                <input name="requestorName" id="requestorName" class="form-control" required value="<?php
                                                                                                    echo !empty($_SESSION['PreferredName']) ? $_SESSION['PreferredName'] . " " . $_SESSION['LastName'] : $_SESSION['FirstName'] . " " . $_SESSION['LastName'];
                                                                                                    ?>"></input>
                <input type="hidden" name="requestorUserID" id="requestorUserID" value="<?php echo $_SESSION['userID']; ?>"></input>
                <label for="primaryContact">Primary Contact</label>
                <input name="primaryContact" id="primaryContact" class="form-control" required>
                <label for="phoneNumber">Phone Number</label>
                <input name="phoneNumber" id="phoneNumber" class="form-control" type="tel" required>
            </div>
            <div class="d-flex flex-row justify-content-between gap-2 mt-2">
                <div>
                    <label for="additionalContacts">Additional Contacts to be notified and updated regarding this request</label>
                    <p class="form-text">Hold Ctrl + Click to select multiple contacts</p>
                </div>
                <select name="additionalContacts[]" id="additionalContacts" class="form-control" multiple></select>

            </div>
            <div class="d-flex flex-row justify-content-between gap-2 mt-2">
                <label for="desiredResponse">Desired Response</label>
                <select name="desiredResponse" id="desiredResponse" class="form-control" required>
                    <option value="0">Emergency</option>
                    <option value="1">Immediate</option>
                    <option value="2">Non Emergency, Normal</option>
                </select>
            </div>
            <div class="d-flex flex-row justify-content-end gap-2 mt-2">
                <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
    // API file is currently set to only return a single value, Facility Problem, until further notice
    // select element is set to disabled until further notice
    function renderRequestTypeSelect() {
        fetch("./API/getFacilitiesRequestTypes.php")
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var issueTypeSelect = document.getElementById("issueType");
                data.forEach(issueType => {
                    var option = document.createElement("option");
                    option.value = issueType.id;
                    option.textContent = issueType.sType;
                    issueTypeSelect.appendChild(option);
                });
            })
    }

    function renderRequestLocationSelect() {
        fetch("./API/getFacilitiesRequestLocations.php")
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var issueLocationSelect = document.getElementById("issueLocation");
                data.forEach(issueLocation => {
                    var option = document.createElement("option");
                    option.value = issueLocation.sLocUid;
                    option.textContent = issueLocation.sLocName;
                    issueLocationSelect.appendChild(option);
                });
            })
    }

    function renderRequestAdditionContactsMultiSelect() {
        // $dept = $_SESSION['DepartmentNumber'];
        // $dept = '41515';
        // fetch("./API/getAllUsersFromDepartment.php?dept=" + $dept)
        fetch("./API/getAllUsersFromDepartment.php")
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var additionalContactsSelect = document.getElementById("additionalContacts");
                data.forEach(contact => {
                    var option = document.createElement("option");
                    option.value = contact.sEmail;
                    option.textContent = contact.sFirstName + " " + contact.sLastName;
                    additionalContactsSelect.appendChild(option);
                });
            })
    }

    renderRequestTypeSelect();
    renderRequestLocationSelect();
    renderRequestAdditionContactsMultiSelect();
</script>
<style>
    .main {
        grid-template-columns: 1fr;
        margin: 20px;
        padding: 10px;
        /* display: grid;
        grid-template-rows: 1fr 1fr; */
    }

    .content {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        font-size: medium;
        min-width: 50%;
        max-width: 90%;
        margin: 20px;

        form {

            border-radius: 10px;
            border: 1px solid var(--accent);
            margin-top: 10px;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr;
            min-height: 60%;
            max-width: 90%;
            gap: 20px;

            label {
                display: block ruby;
                ruby-position: over;
                font-weight: bold;
            }


            width: 90%;
            background-color: var(--bg);
        }
    }

    .hidden {
        display: none !important;
    }

    #additionalContacts option:checked {
        background-color: var(--accent);
        color: #1E242B;
        padding-right: 5px;
    }

    #additionalContacts option:checked::after {
        content: ' ✔';
    }

    #additionalContacts {
        field-sizing: unset;
    }
</style>