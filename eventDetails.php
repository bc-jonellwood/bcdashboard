<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/01 13:48:52
include "./components/header.php";

$sEventID = $_GET['eventID'];

?>
<script src="./functions/parseDateAndTime.js"></script>
<script src="./functions/getTimeBetweenDates.js"></script>
<script src="./functions/createSessions.js"></script>
<script>
    function toggleAllDay() {

        let eventAllDay = document.getElementById("eventAllDay").checked;
        console.log(eventAllDay);
    }

    function renderAllDayOptions(val) {
        var maxAttendees = document.getElementById("eventMaxAttendees")
        maxAttendees.style.display = 'none';
        // console.log(val);
        let html = "";
        if (val == 1) {
            // console.log("all day");
            html += `
            <div class="form-check">
                <label for="maxAttendees" class="form-label">Max Attendees 
                    <input type=number id="maxAttendees" name="maxAttendees" min="1" max="100" value="0" onchange="renderMaxAttendees()">
                </label>
            </div>
            `
            document.getElementById("eventAllDayOptions").innerHTML = html;
        } else if (val == 2) {
            // console.log("sessions");
            html += `
            <div class="form-check">
                <label for="maxAttendees" class="form-label">Max Attendees per Session
                    <input type=number id="maxAttendees" name="maxAttendees" min="1" max="100" value="0" onchange="renderMaxAttendees()">
                </label>
                <label for="sessionLength" class="form-label">Sessions Length
                    <select class="form-control" id="dataList" onchange="renderSessions()">
                            <option selected disabled value="">Choose...</option>
                            <option value="15">15 Minutes</option>
                            <option value="30">30 Minutes </option>
                            <option value="60">60 Minutes</option>
                            <option value="90">90 Minutes</option>
                            <option value="120">2 hours</option>
                            <option value="180">3 hours</option>
                            <option value="240">4 hours</option>
                    </select>
                </label>
            </div>
            `
            document.getElementById("eventAllDayOptions").innerHTML = html;
        }
    }


    var html = "";
    var settingsHtml = '';
    fetch(`./API/getSingleEvent.php?eventID=<?php echo $sEventID; ?>`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            html += `
            <div class="shadow-sm event-card">
                <div class="event-card-body">
                    <p class="event-card-text"><b>Title:</b> ${data[0].sTitle}</p>
                    <p class="event-card-text"><b>Description:</b> ${data[0].sDescription}</p>
                    <p class="event-card-text"><b>Location:</b> ${data[0].sLocation}</p>
                    <p class="event-card-text"><b>Start Date:</b> ${parseDateAndTime(data[0].dtStartDate).date} @ ${parseDateAndTime(data[0].dtStartDate).time}</p> 
                    <p class="event-card-text"><b>End Date:</b> ${parseDateAndTime(data[0].dtEndDate).date} @ ${parseDateAndTime(data[0].dtEndDate).time}</p>
                    <p class="event-card-text"><b>Status:</b> ${data[0].sStatus}</p>
                    <p class="event-card-text"><b>Created By:</b> ${data[0].iCreatedBy}</p>
                </div>
                <div class="flex-row gap-4 event-card-options d-flex">
                    <div class="form-check">
                        <label for="cbActive" class="form-label">Active
                            <input type="checkbox" id="eventActive" name="cbActive" ${data[0].sStatus == "active" ? "checked" : ""} class="form-check-input">
                        </label>
                    </div>
                    <div> | </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="eventAllDay" id="eventAllDay1" value="1"  onchange="renderAllDayOptions(this.value)">
                            <label class="form-check-label" for="eventAllDay1">
                                All Day
                            </label>
                       </div>
                       <div class="form-check">
                        <input class="form-check-input" type="radio" name="eventAllDay" id="eventAllDay2" value="2" onchange="renderAllDayOptions(this.value)">
                            <label class="form-check-label" for="eventAllDay2">
                                Sessions
                            </label>
                        </div>
                        <div> | </div>
                        <div class="form-check">
                        <label for="singleLocation" class="form-label hidden" id="singleLocationLabel">All same location
                            <input type="checkbox" id="singleLocation" name="singleLocation" class="form-check-input" checked onchange="resetLocationOptions()">
                        </label>
                    </div>
                    </div>
                    <div id="eventAllDayOptions"></div>
                    <div id="eventSessionDetails"></div>
                </div>
                <p class="event-card-id" ><b>Event ID:</b> ${data[0].event_id}</p>
            </div>
            `;
            let start = parseDateAndTime(data[0].dtStartDate).date;
            let end = parseDateAndTime(data[0].dtEndDate).date;
            let sTime = parseDateAndTime(data[0].dtStartDate).time;
            let eTime = parseDateAndTime(data[0].dtEndDate).time;
            let duration = getTimeBetweenDates(start, sTime, end, eTime);
            settingsHtml += `
                <p data-duration="${duration}" id="duration-hours">Event Duration: ${duration} hours</p>
                <p data-time="${sTime}" value="${sTime}" id="event-start-time">Starting at: ${sTime}</p>
            `
            document.getElementById("eventDetails").innerHTML = html;
            document.getElementById("eventDuration").innerHTML = settingsHtml;
        });
</script>
<div class="main">
    <?php include "./components/sidenav.php" ?>

    <div id="eventDetails"></div>
    <div id="eventSetting" class="eventSetting">
        <div id="eventDuration"></div>
        <div id="eventMaxAttendees"></div>
        <div id="eventSessions"></div>
        </ /div id="eventSessionDetails">
    </div>
</div>
</div>

<?php include "./components/footer.php"; ?>

<script>
    function renderMaxAttendees() {
        var maxAttendeesEl = document.getElementById("eventMaxAttendees").style.display = 'block';
        var maxAttendees = document.getElementById("maxAttendees").value;
        document.getElementById("eventMaxAttendees").innerHTML = `
        <p>Max Attendees: ${maxAttendees}</p>
        `
    }



    function renderSessions() {
        var eventStartTime = document.getElementById("event-start-time").dataset.time;
        var eventDuration = document.getElementById("duration-hours");
        var eventHours = eventDuration.dataset.duration;
        // console.log(eventHours);
        var maxAttendees = document.getElementById("maxAttendees").value;
        var sessionsEl = document.getElementById("eventSessions").style.display = 'block';
        var sessions = document.getElementById("dataList").value;
        var singleLocationCheck = document.getElementById("singleLocationLabel")
        singleLocationCheck.classList.remove('hidden');
        document.getElementById("eventSessionDetails").innerHTML = '';
        document.getElementById("eventSessions").innerHTML = `
        <p class="hidden">Event Duration: ${eventHours}</p>
        <p class="hidden">Start Time: ${eventStartTime}</p>
        <p class="hidden">Sessions Length: ${sessions} minutes</p>
        <p class="hidden">Max Attendees: ${maxAttendees}</p>
        
        `
        var sessions = createSessions(eventStartTime, sessions, maxAttendees, eventHours);
        for (let i = 0; i < sessions.length; i++) {

            console.log(sessions[i]);
            document.getElementById("eventSessionDetails").innerHTML += `
            <div class="session-card">
                <p>Session start: ${sessions[i].startTime}</p>
                <p>Attendees Allowed: ${sessions[i].maxAttendees}</p>
                <p>Location: 
                    <select class="form-control required" data-slot-id="${sessions[i].slot_id}" name="slotLocation" onchange="changeAllLocations(this.value)">
                        <option value="" selected disabled>Choose...</option>
                        <option value="4">Assembly Room</option>
                        <option value="23">BCWS Engineering Conference Room</option>
                        <option value="28">BCWS Executive Conference Room</option>
                        <option value="24">BCWS Operations Bay Area</option>
                        <option value="25">BCWS Solid Waste Bay Area</option>
                        <option value="27">BCWS Training Room</option>
                        <option value="29">BCWS Treatment Plant Breakroom/Shed Area</option>
                        <option value="6">Council's Conference Room (Room 100)</option>
                        <option value="5">Council's Conference Room (Room 125)</option>
                        <option value="22">Courthouse - Courtroom A</option>
                        <option value="18">Courthouse - Courtroom E</option>
                        <option value="16">Courthouse - Grand Jury Room</option>
                        <option value="10">Courthouse - Jury Panel Room</option>
                        <option value="17">Courthouse - Jury Room B</option>
                        <option value="13">Dean Hall - Cypress Gardens</option>
                        <option value="20">Emergency Services Training Center</option>
                        <option value="34">EOC - EMD Training (Admin Bldg)</option>
                        <option value="31">Fleet Management Director's Office</option>
                        <option value="9">Goose Creek Satellite Office</option>
                        <option value="36">Heritage Room - Cypress Gardens</option>
                        <option value="8">Human Resources Department</option>
                        <option value="33">IT Multi Function Room</option>
                        <option value="19">Live Oak Complex - Magistrate Courtroom A</option>
                        <option value="14">Live Oak Complex - Magistrate Courtroom B</option>
                        <option value="15">Live Oak Complex - Magistrate Courtroom C</option>
                        <option value="11">Live Oak Complex - Other</option>
                        <option value="1">Multi-Purpose Room (Room 106B)</option>
                        <option value="37">SO Annex</option>
                        <option value="32">Supervisors Conference Room</option>
                        <option value="35">Wellness Clinic</option>
                    </select>
                </p>   
                <p class="event-card-id">Slot ID: ${sessions[i].slot_id}</p>
            </div>
            `

        }
    }

    function changeAllLocations(location) {
        var singleLocationCheck = document.getElementById("singleLocation").checked;
        var slots = document.querySelectorAll('[data-slot-id]');
        if (singleLocationCheck) {
            for (let i = 0; i < slots.length; i++) {
                slots[i].value = location;
            }
        } else {
            return;
        }
    }

    function resetLocationOptions() {
        var slots = document.querySelectorAll('[data-slot-id]');
        for (let i = 0; i < slots.length; i++) {
            slots[i].value = "";
        }
    }
</script>
<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        display: grid;
        grid-template-columns: 3fr 2fr;
    }

    .event-card {
        border: 1px solid #000;
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        border: 1px solid;
        border-color: var(--accent)
    }

    .event-card-id {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        font-size: 14px;
        color: var(--accent);
    }

    .eventSetting {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    #dataList option {
        background-color: var(--bg);
        color: var(--fg);
    }

    .session-card {
        border: 1px solid var(--accent);
        padding: 10px;
        margin: 10px;
    }
</style>