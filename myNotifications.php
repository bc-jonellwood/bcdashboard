<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/23 08:11:24
include "./components/header.php"
?>
<script src="./functions/getNotifications.js"></script>
</ /script src="./functions/renderNotificationCalendar.js">
</script>
<script src="./functions/renderNotificationsAgenda.js"></script>
<script src="./functions/parseDateAndTime.js"></script>
<script src="./functions/parseTime.js"></script>
<script src="./functions/deleteNotification.js"></script>
<script src="./functions/recoverNotification.js"></script>
<!-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script> -->

</script>

<!-- <body class="mode-dark theme-base" onload="getNotifications()"> -->
<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <form class="needs-validation" novalidate action="./API/addNotification.php" method="POST" id="notificationForm">
            <div class="form-row">
                <div class="mb-3">
                    <label for="sNotificationType">Notification Type</label>
                    <select class="form-control" id="sNotificationType" name="sNotificationType" placeholder="Type of Notification" required onchange="updateAlert()">
                        <option selected disabled value="">Choose...</option>
                        <option value="alert">Alert</option>
                        <option value="warning">Warning</option>
                        <option value="information">Information Only</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        What are you a moron?
                    </div>
                    <small id="sNotificationTypeHelpBlock" class="form-text text-muted help-text">
                        The type of notification will decide what color the background will be and what icon will be displayed. They are ranked in order of most severe to least.
                    </small>
                </div>
                <div class="mb-3">
                    <label for="sNotificationText">Notification Text</label>
                    <textarea class="form-control" id="sNotificationText" name="sNotificationText" placeholder="Notification Text" required rows="3" maxlength="255" oninput="updateAlert()"></textarea>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        What are you a stupid face?
                    </div>
                    <small id="sNotificationTextHelpBlock" class="form-text text-muted help-text">
                        Enter the text you want displayed on the alart. It is limited to 255 characters.
                    </small>
                </div>
                <div class="col-md-2 mb-3 datepickers">
                    <label for="dtStartDate">Start Date
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" id="dtStartDate" name="dtStartDate" required value="{{ new Date().getFullYear() }}-{{ new Date().getMonth() + 1 }}-{{ new Date().getDate() }}">
                            <div class=" invalid-feedback">
                                Please do better.
                            </div>
                        </div>
                    </label>
                    <!-- <label for="dtStartTime">Start Time
                            <div class="input-group">
                                <input type="time" class="form-control" id="dtStartTime" name="dtStartTime" step="900" value="00:00" required>
                                <div class="invalid-feedback">
                                    Please do better.
                                </div>
                            </div>
                            <span class="validity"></span>
                        </label> -->
                    <label for="dtEndDate">End Date
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" id="dtEndDate" name="dtEndDate" required>
                            <div class="invalid-feedback">
                                Time Slots are allowed only in 15 min increments.
                            </div>
                        </div>
                    </label>
                    <!-- <label for="dtEndTime">End Time
                            <div class="input-group">
                                <input type="time" class="form-control" id="dtEndTime" name="dtEndTime" step="900" value="00:00" required>
                                <div class="invalid-feedback">
                                    ime Slots are allowed only in 15 min increments.
                                </div>
                            </div>
                            <span class="validity"></span>
                        </label> -->
                </div>
                <div id="dateError" class="invalid-date-feedback"></div>
            </div>
            <div class="form-row">
                <div class="mb-3">
                    <label for="sStatus">Status</label>
                    <select class="form-control" id="sStatus" name="sStatus" required>
                        <option selected value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <div class="invalid-feedback">
                        Please provide a valid status.
                    </div>
                    <small id="sNotificationTextHelpBlock" class="form-text text-muted help-text">
                        Select "Inactive" if want to create the Alert but are not ready to commit to it being displayed. It will have to be updated to Active before it will be displayed.
                    </small>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">
                        I understand the consequences of this action
                    </label>
                </div>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
            <button class="btn btn-primary" type="button" onclick="validateForm()">Submit</button>
            <button class="btn btn-danger" type="reset" onclick="clearAlert()">Reset</button>
            <!-- <button class="btn btn-info" type="button" onclick="validateForm()">Magic</button> -->
        </form>
    </div>
    <div class="content">
        <div id="recentNotificationsContent" class="recentNotificationsContent">
            <div id="calendar"></div>
        </div>
        <div class="calendar-holder">
        </div>
    </div>
    <script>
        function editNotification(id) {
            alert("Edit Notification " + id);
        }
    </script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <script>
        document.querySelectorAll('input[type="time"]').forEach(input => {
            input.addEventListener('change', () => {
                // console.log(input.validity.valid);
                if (input.validity.valid) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            })
        })
    </script>
    <script>
        function setDateDefault(id) {
            const dateInput = document.getElementById(id);
            const now = new Date();
            const year = now.getFullYear();
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            const hour = now.getHours().toString().padStart(2, '0');
            const minute = now.getMinutes().toString().padStart(2, '0');
            const second = now.getSeconds().toString().padStart(2, '0');
            dateInput.value = `${year}-${month}-${day}T${hour}:${minute}:${second}`;
        }
    </script>
    <script>
        function clearAlert() {
            document.getElementById('alert-text').innerText = '';
            document.getElementById('alert-text').parentElement.classList.remove('alert', 'warning', 'information', 'other');
            document.getElementById('dateError').innerText = '';
            setDateDefault('dtStartDate');
            setDateDefault('dtEndDate');
        }

        document.addEventListener('DOMContentLoaded', clearAlert);

        function updateAlert() {
            var alertType = document.getElementById('sNotificationType').value;
            var alertText = document.getElementById('sNotificationText').value;
            var startDate = document.getElementById('dtStartDate').value;
            var endDate = document.getElementById('dtEndDate').value;
            var status = document.getElementById('sStatus').value;
            var alertText = document.getElementById('sNotificationText').value;
            var alert = alertType + " | " + alertText;
            var alertBox = document.getElementById('alert-text')
            var alertHolder = alertBox.parentElement;
            alertHolder.classList.remove('alert', 'warning', 'information', 'other');
            alertBox.innerText = alert;
            alertHolder.classList.add(alertType);
        }
    </script>
    <script>
        // function to validate form data before submitting 
        // we will check that the starting date is before the ending date
        // we will make sure the start date is a day in the future
        // we will we make an array of the dates already being used for notifications from a fetch request and then make sure the start date is not in that array
        // we are already getting the data from the fetch request in the getNotifications function on load. maybe we can use the data to populate the array?

        async function validateForm() {
            const form = document.getElementById('notificationForm');
            // const ranges = await getNotifications();
            const ranges = await getNotificationDataNoRender();
            const errorTextHolder = document.getElementById('dateError')
            errorTextHolder.innerText = '';

            var dtStartDate = document.getElementById('dtStartDate').value;
            var dtEndDate = document.getElementById('dtEndDate').value;
            if (!dtStartDate || !dtEndDate) {
                errorTextHolder.innerText = "Please enter a start and end date";
                return false;
            }

            if (new Date(dtStartDate) < new Date()) {
                errorTextHolder.innerText = "Start date must be in the future";
                return false;
            }
            if (new Date(dtEndDate) < new Date()) {
                errorTextHolder.innerText = "End date must be in the future";
                return false;
            }

            if (new Date(dtEndDate) < new Date(dtStartDate)) {
                errorTextHolder.innerText = "End date must be after start date";
                return false;
            }

            const newRange = createRange(dtStartDate, dtEndDate);
            const hasOverlaps = checkForOverlap(ranges, newRange)
            if (hasOverlaps) {
                var errorText = "Your selection overlaps with an existing notification. Please choose a different time period."
                errorTextHolder.innerText = errorText;
                return false;
            } else {
                form.submit();
                // return true;
            }
        }
    </script>
</div>
</div>
</body>
<?php include "./components/footer.php" ?>
<script>
    function updateButtonText(id, status) {
        const button = document.getElementById(`button-${id}`);
        button.textContent = status === 'active' ? 'Delete' : 'Recover';
        button.setAttribute('onclick', status === 'active' ? `deleteNotification('${id}')` : `recoverNotification('${id}')`);

    }
    document.addEventListener('DOMContentLoaded', function() {
        getNotifications();
    })
</script>

</html>
<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        display: grid;
        grid-template-columns: 3fr 2fr;
    }

    .content {
        padding: 20px;
        background-color: var(--bg);
    }

    .help-text {
        font-size: clamp(12px, 2vw, 16px);
    }

    #alert-text {
        text-transform: capitalize;
    }

    .datepickers {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2em;
    }

    .alert {
        background-color: red;
    }

    .warning {
        background-color: orange;
    }

    .information {
        background-color: blue;
        color: var(--fg)
    }

    .other {
        background-color: green;
    }

    .reset-btn {
        background-color: var(--accent);
    }

    .recentNotificationsContent {
        height: 100vh;
        overflow-y: auto;
        scrollbar-gutter: stable;
        padding-right: 20px;
    }

    .notification-badge {
        color: transparent;
        border-radius: 50%;
        /* translate: -10px -10px; */
        width: 1.5em;
        height: 1.5em;
        margin-right: -2.5em;

    }

    .corner-only {
        --s: 25px;
        /* size of the corners */
        border: 5px solid #005677;
        padding: 6px;
        /* height: 250px; */
        /* width: 300px; */
        /* background: #f2f2f2 content-box; */
        mask:
            conic-gradient(#000 0 0) content-box,
            conic-gradient(at var(--s) var(--s), #0000 75%, #000 0) 0 0/calc(100% - var(--s)) calc(100% - var(--s));
    }

    /* .notification-badge:after {
        content: "P";
    } */

    /* .month-title {
        background-color: var(--accent);
        color: var(--bg);
        padding: 5px;
        border-radius: 7px;
        padding-left: 1em;
    } */

    .entry {
        padding-left: 15px;
        font-size: medium;
        margin-top: 1em;
    }

    .inactive {
        opacity: 0.25;
    }

    .notification-top-bar {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .notification-type {
        font-size: medium;
        text-transform: capitalize;
    }

    .notification-text {
        font-size: medium;
        font-family: monospace;
        padding: 20px;
        /* border-top: 1px solid var(--accent);
        border-bottom: 1px solid var(--accent); */
        columns: var(--accent);
    }

    .form-check {
        font-size: medium !important;
        margin-bottom: 1em !important;
    }

    .n-alert {
        background-color: red;
        color: var(--fg);
    }

    .n-information {
        background-color: blue;
        color: var(--white);
    }

    .n-warning {
        background-color: orange;
        color: var(--black);
    }

    .n-other {
        background-color: green;
        color: var(--fg);
    }

    .invalid-date-feedback {
        width: 100%;
        font-size: medium;
        color: light-dark(red, #c70000);
    }

    .is-valid {
        border: green 1px solid;
    }

    .is-invalid {
        border: red 1px solid;
    }

    .notification-buttons-holder {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 10px;
        /* padding: 10px; */
        padding-top: 10px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--fg);
    }

    details {
        margin-bottom: 1em;
    }
</style>