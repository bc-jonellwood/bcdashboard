<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/26 16:02:06
include "./components/header.php"
?>
<script src="./functions/getNotifications.js"></script>
<script src="./functions/renderNotificationCalendar.js"></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>

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
                                <input type="datetime-local" class="form-control" id="dtStartDate" name="dtStartDate" required>
                                <div class="invalid-feedback">
                                    Please do better.
                                </div>
                            </div>
                        </label>
                        <label for="dtEndDate">End Date
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="dtEndDate" name="dtEndDate" required>
                                <div class="invalid-feedback">
                                    Please do better.
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="mb-3">
                        <label for="sStatus">Status</label>
                        <select class="form-control" id="sStatus" name="sStatus" required>
                            <option selected value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid city.
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
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit form</button>
                <button class="btn btn-danger" type="reset" onclick="clearAlert()">Reset</button>
            </form>
        </div>
        <div class="content">
            <!-- <p>The idea would be to display here a calendar of existing alerts. And maybe somehow use that data for validation in the form against overlapping alerts</p>
            <p>But for now, lets just get the form working.</p> -->
            <div id="recentNotificationsContent">
                <div id="calendar"></div>
            </div>
            <div class="calendar-holder">

                <full-calendar shadow options='{
                    "headerToolbar": {
                        "left": "prev,next today",
                        "center": "title",
                        "right": "dayGridMonth,dayGridWeek,dayGridDay"
                        }
                        
                        }' />
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
            function clearAlert() {
                document.getElementById('alert-text').innerText = '';
                document.getElementById('alert-text').parentElement.classList.remove('alert', 'warning', 'information', 'other');
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
    </div>
    </div>
</body>
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

    .calendar-header {
        display: flex;
        justify-content: space-between;
        background-color: var(--accent);
        color: var(--bg);
        font-weight: bold;
        padding: 10px;

        button {
            color: var(--bg);
        }
    }

    .calendar-table {
        width: 100%;
    }

    .event {
        margin: 0;
        padding: 0;


        ul {
            margin: 0 !important;
            padding: 0 !important;
        }

        li {
            list-style-type: none;
            font-size: small;
            margin-left: 0;
            padding-left: 0;
            background-color: yellow;
            color: black;


        }
    }

    .calendar-body {
        width: 100%;

        thead {
            width: 100%;
        }

        tr {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        th {
            width: 100%;
            justify-content: space-between;
            background-color: var(--accent);
            color: var(--bg);
            font-weight: bold;
            padding: 10px;
            font-size: medium;
            border-top: 1px solid;
            border-bottom: 1px solid;
            border-color: dark-light(var(--bg), var(--accent));
        }

        td {

            border: 1px solid var(--accent);
            border-style: inset;
            width: calc(100% / 7);
            max-width: calc(100% / 7);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }

    #recentNotificationsContent {
        display: none;
        ;
    }

    .fc-button {
        /* background-color: var(--accent) !important; */
        background-color: hotpink !important;
        color: var(--bg) !important;
        font-size: small !important;
    }

    .fc-button-group {
        margin-bottom: 20px !important;
        padding-bottom: 20px !important;
    }

    .calendar-holder {
        width: 90%;
        overflow: hidden;
    }
</style>