<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/27 15:45:58
include "./components/header.php"
?>
<script src="./functions/getNotifications.js"></script>
</ /script src="./functions/renderNotificationCalendar.js">
</script>
<script src="./functions/renderNotificationsAgenda.js"></script>
<script src="./functions/parseDateAndTime.js"></script>
<!-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script> -->

</script>

<body class="mode-dark theme-base" onload="getNotifications()">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <form class="needs-validation" novalidate action="./API/addNotification.php" method="POST">
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
                                <input type="date" class="form-control" id="dtStartDate" name="dtStartDate" required value="{{ new Date().toISOString().replace('Z', '') }}">
                                <div class="invalid-feedback">
                                    Please do better.
                                </div>
                            </div>
                        </label>
                        <label for="dtStartTime">Start Time
                            <div class="input-group">
                                <input type="time" class="form-control" id="dtStartTime" name="dtStartTime" step="900" value="00:00" required>
                                <div class="invalid-feedback">
                                    Please do better.
                                </div>
                            </div>
                            <span class="validity"></span>
                        </label>
                        <label for="dtEndDate">End Date
                            <div class="input-group">
                                <input type="date" class="form-control" id="dtEndDate" name="dtEndDate" required>
                                <div class="invalid-feedback">
                                    Time Slots are allowed only in 15 min increments.
                                </div>
                            </div>
                        </label>
                        <label for="dtEndTime">End Time
                            <div class="input-group">
                                <input type="time" class="form-control" id="dtEndTime" name="dtEndTime" step="900" value="00:00" required>
                                <div class="invalid-feedback">
                                    ime Slots are allowed only in 15 min increments.
                                </div>
                            </div>
                        </label>
                        <span class="validity"></span>
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
                <button class="btn btn-primary" type="submit">Submit form</button>
                <button class="btn btn-danger" type="reset" onclick="clearAlert()">Reset</button>
                <button class="btn btn-info" type="button" onclick="validateForm()">Magic</button>
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
                // const hour = now.getHours().toString().padStart(2, '0');
                // const minute = now.getMinutes().toString().padStart(2, '0');
                // const second = now.getSeconds().toString().padStart(2, '0');
                dateInput.value = `${year}-${month}-${day}`;
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
                //console.log('Here comes the magic')
                const notificationDates = await getNotifications();
                const errorTextHolder = document.getElementById('dateError')
                errorTextHolder.innerText = '';
                // notificationDates.forEach(dates => {
                //     console.log(dates);
                // })

                var startDate = document.getElementById('dtStartDate').value;
                // console.log(startDate);
                var endDate = document.getElementById('dtEndDate').value;
                const startDateIso = startDate.split('T')[0];
                const endDateIso = endDate.split('T')[0];

                if (startDateIso > endDateIso || startDateIso == endDateIso) {
                    console.log('Start Date is equal to or after End Date');
                    return false;
                }
                console.log("Start Date is before End Date");
                // return true;
                if (notificationDates.flat().includes(startDateIso)) {
                    console.log("Date in array");
                    var errorText = "There is an existing notification for this date. Please choose a different date.";
                    errorTextHolder.innerText = errorText;
                    return false;
                } else {
                    console.log("Date not in array");
                    // return true;
                }


            }
        </script>
    </div>
    </div>
</body>
<?php include "./components/footer.php" ?>

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

    /* .notification-badge:after {
        content: "P";
    } */

    .month-title {
        background-color: var(--accent);
        color: var(--bg);
        padding: 5px;
        border-radius: 7px;
        padding-left: 1em;
    }

    .entry {
        padding-left: 15px;
        font-size: medium;
        margin-top: 1em;
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
        border-top: 1px solid var(--accent);
        border-bottom: 1px solid var(--accent);
    }

    .form-check {
        font-size: medium !important;
        margin-bottom: 1em !important;
    }

    .n-alert {
        background-color: red;
        color: red;
    }

    .n-information {
        background-color: blue;
        color: blue;
    }

    .n-warning {
        background-color: orange;
        color: orange;
    }

    .n-other {
        background-color: green;
        color: green;
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

    /* input[type="number"] {
        width: 100px;
    } */

    /* input+span {
        padding-right: 30px;
    }

    input:invalid+span::after {
        position: absolute;
        content: "✖";
        padding-left: 5px;
    }

    input:valid+span::after {
        position: absolute;
        content: "✓";
        padding-left: 5px;
    } */
</style>