<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/11 08:53:13
include "./components/header.php";

$sEventID = $_GET['eventID'];

?>
<script src="./functions/parseDateAndTime.js"></script>
<script src="./functions/getTimeBetweenDates.js"></script>
<script src="./functions/createSessions.js"></script>
<script src="./functions/createDeleteConfirmationPopover.js"></script>
<script>
    function toggleAllDay() {

        let eventAllDay = document.getElementById("eventAllDay").checked;
        // console.log(eventAllDay);
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
    var formHtml = '';
    fetch(`./API/getSingleEventForEdit.php?eventID=<?php echo $sEventID; ?>`)
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            var event = data.event;

            html += `
            <div class="shadow-sm event-card">
                <div class="event-card-body">
                    <p class="event-card-text"><b>Title:</b> ${event.sTitle}</p>
                    <p class="event-card-text"><b>Description:</b> ${event.sDescription}</p>
                    
                    <p class="event-card-text"><b>Start Date:</b> ${parseDateAndTime(event.dtStartDate).date} @ ${parseDateAndTime(event.dtStartDate).time}</p> 
                    <p class="event-card-text"><b>End Date:</b> ${parseDateAndTime(event.dtEndDate).date} @ ${parseDateAndTime(event.dtEndDate).time}</p>
                    <p class="event-card-text"><b>Status:</b> ${event.sStatus}</p>
                    <p class="event-card-text"><b>Created By:</b> ${event.iCreatedBy}</p>
                </div>
                <div class="flex-row gap-4 event-card-options d-flex">
                    <button class="btn btn-sm btn-danger" type="button" onclick="createDeleteConfirmationPopover('${event.event_id}', 'deleteEvent', 'event')" popovertarget="deleteConfirmationPopover" popovertargetaction="show">Delete</button>
                    </div>
                    <div id="eventAllDayOptions"></div>
                    
                </div>
                <p class="event-card-id" ><b>Event ID:</b> ${event.event_id}</p>
            </div>
            `;
            let start = parseDateAndTime(event.dtStartDate).date;
            let end = parseDateAndTime(event.dtEndDate).date;
            let sTime = parseDateAndTime(event.dtStartDate).time;
            let eTime = parseDateAndTime(event.dtEndDate).time;
            let duration = getTimeBetweenDates(start, sTime, end, eTime);
            settingsHtml += `
                <p data-duration="${duration}" id="duration-hours">Event Duration: ${duration} hours</p>
                <p data-time="${sTime}" value="${sTime}" id="event-start-time">Starting at: ${sTime}</p>
            `
            formHtml += `
                <input type="hidden" name="eventID" id="eventID" value="${event.event_id}" />
            `
            document.getElementById("eventDetails").innerHTML = html;
            renderSessions(data);
            // document.getElementById("eventDuration").innerHTML = settingsHtml;
            // document.getElementById("eventIDInput").innerHTML = formHtml;
        });

    function renderSessions(data) {
        //console.log('Data from sessions func')
        //console.log(data)
        var sessionHTML = '<div counter-reset-"index" class="eventSessions">';
        data.slots.forEach(slot => {
            // console.log(slot.slot_id);
            sessionHTML += `
            <div class="session-card" id="${slot.slot_id}">
                <p>Session start: ${slot.slotStartTime}</p>
                <p>Attendees Allowed: ${slot.slotMaxAttendees}</p>
                <p class="slotLocationName">Location: ${slot.slotLocationName}</p>
                <button class="btn btn-sm btn-danger" type="button" onclick="createDeleteConfirmationPopover('${slot.slot_id}', 'deleteSession', 'session')" popovertarget="deleteConfirmationPopover" popovertargetaction="show">Delete</button>
               </div>
            `
        })
        sessionHTML += '</div>';
        document.getElementById("eventSessions").innerHTML += sessionHTML;
    }

    function deleteSession(id) {
        fetch(`./API/deleteSession.php?id=${id}`)
        document.getElementById(id).remove();
    }

    function deleteEvent(id) {
        fetch(`./API/deleteEvent.php?id=${id}`)
        window.location.href = "./myEvents.php";
    }
</script>
<div class="main">
    <?php include "./components/sidenav.php" ?>

    <div id="eventDetails"></div>
    <div id="eventSetting" class="eventSetting">
        <div id="eventDuration"></div>
        <div id="eventMaxAttendees"></div>
        <div id="eventSessions"></div>
        <!-- <div id="sessionsForm">Event Form
            <form id="sessionForm" action="./API/addSessions.php" method="POST">
                <div id="eventIDInput"></div>
                <input type="hidden" id="maxSessionAttendeesInput" name="maxSessionAttendeesInput" value="">
                <div id="eventSessionInputs"></div>
                <div id="eventSessionDetails"></div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div> -->

    </div>
</div>
</div>
<div class="deleteConfirmationPopover" id="deleteConfirmationPopover" name="deleteConfirmationPopover" popover="manual" name="deleteConfirmationPopover"></div>
<?php include "./components/footer.php"; ?>

<script>
    function renderMaxAttendees() {
        var maxAttendeesEl = document.getElementById("eventMaxAttendees").style.display = 'block';
        var maxAttendees = document.getElementById("maxAttendees").value;
        var maxSessionAttendeesInput = document.getElementById("maxSessionAttendeesInput");
        maxSessionAttendeesInput.value = maxAttendees;
        document.getElementById("eventMaxAttendees").innerHTML = `
        <p>Max Attendees: ${maxAttendees}</p>
        `
        resetSessionLength();
    }



    // function renderSessions() {
    //     var eventStartTime = document.getElementById("event-start-time").dataset.time;
    //     var eventDuration = document.getElementById("duration-hours");
    //     var eventHours = eventDuration.dataset.duration;
    //     // console.log(eventHours);
    //     var maxAttendees = document.getElementById("maxAttendees").value;
    //     var sessionsEl = document.getElementById("eventSessions").style.display = 'block';
    //     var sessions = document.getElementById("dataList").value;
    //     var singleLocationCheck = document.getElementById("singleLocationLabel")
    //     singleLocationCheck.classList.remove('hidden');
    //     document.getElementById("eventSessionDetails").innerHTML = '';
    //     document.getElementById("eventSessions").innerHTML = `
    //     <p class="hidden">Event Duration: ${eventHours}</p>
    //     <p class="hidden">Start Time: ${eventStartTime}</p>
    //     <p class="hidden">Sessions Length: ${sessions} minutes</p>
    //     <p class="hidden">Max Attendees: ${maxAttendees}</p>
    //     `
    //     document.getElementById("eventSessionInputs").innerHTML = `
    //     <input type="hidden" name="eventDurationHours" id="eventDurationHours" value="${eventHours}" />
    //     <input type="hidden" name="eventStartTime" id="eventStartTime" value="${eventStartTime}" />
    //     <input type="hidden" name="eventSessionLengthMinutes" id="eventSessionLengthMinutes" value="${sessions}" minutes />
    //     `
    //     var sessions = createSessions(eventStartTime, sessions, maxAttendees, eventHours);
    //     for (let i = 0; i < sessions.length; i++) {

    //         console.log(sessions[i]);
    //         document.getElementById("eventSessionDetails").innerHTML += `
    //         <div class="session-card">
    //             <input type="hidden" name="slot_id-${i}" value="${sessions[i].slot_id}" />
    //             <input type="hidden" name="slot_start_time-${i}" data-slot-id="${sessions[i].slot_id}" value="${sessions[i].startTime}" />
    //             <p>Session start: ${sessions[i].startTime}</p>
    //             <p>Attendees Allowed: ${sessions[i].maxAttendees}</p>
    //             <p>Location: 
    //                 <select class="form-control required" data-slot-id="${sessions[i].slot_id}" name="slotLocation-${i}" onchange="changeAllLocations(this.value)">
    //                     <option value="" selected disabled>Choose...</option>
    //                     <option value="4">Assembly Room</option>
    //                     <option value="23">BCWS Engineering Conference Room</option>
    //                     <option value="28">BCWS Executive Conference Room</option>
    //                     <option value="24">BCWS Operations Bay Area</option>
    //                     <option value="25">BCWS Solid Waste Bay Area</option>
    //                     <option value="27">BCWS Training Room</option>
    //                     <option value="29">BCWS Treatment Plant Breakroom/Shed Area</option>
    //                     <option value="6">Council's Conference Room (Room 100)</option>
    //                     <option value="5">Council's Conference Room (Room 125)</option>
    //                     <option value="22">Courthouse - Courtroom A</option>
    //                     <option value="18">Courthouse - Courtroom E</option>
    //                     <option value="16">Courthouse - Grand Jury Room</option>
    //                     <option value="10">Courthouse - Jury Panel Room</option>
    //                     <option value="17">Courthouse - Jury Room B</option>
    //                     <option value="13">Dean Hall - Cypress Gardens</option>
    //                     <option value="20">Emergency Services Training Center</option>
    //                     <option value="34">EOC - EMD Training (Admin Bldg)</option>
    //                     <option value="31">Fleet Management Director's Office</option>
    //                     <option value="9">Goose Creek Satellite Office</option>
    //                     <option value="36">Heritage Room - Cypress Gardens</option>
    //                     <option value="8">Human Resources Department</option>
    //                     <option value="33">IT Multi Function Room</option>
    //                     <option value="19">Live Oak Complex - Magistrate Courtroom A</option>
    //                     <option value="14">Live Oak Complex - Magistrate Courtroom B</option>
    //                     <option value="15">Live Oak Complex - Magistrate Courtroom C</option>
    //                     <option value="11">Live Oak Complex - Other</option>
    //                     <option value="1">Multi-Purpose Room (Room 106B)</option>
    //                     <option value="37">SO Annex</option>
    //                     <option value="32">Supervisors Conference Room</option>
    //                     <option value="35">Wellness Clinic</option>
    //                 </select>
    //             </p>   
    //             <p class="event-card-id">Slot ID: ${sessions[i].slot_id}</p>
    //         </div>
    //         `
    //     }
    // }

    function changeAllLocations(location) {
        var singleLocationCheck = document.getElementById("singleLocation").checked;
        var slots = document.querySelectorAll('select[data-slot-id]');
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

    function resetSessionLength() {
        document.getElementById("dataList").value = "";
        document.getElementById("eventSessionDetails").innerHTML = '';
    }
</script>

<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        display: grid;
        grid-template-columns: 1fr 2fr;
    }

    .event-card {

        border: 1px solid #000;
        border-radius: 5px;
        padding: 15px;
        margin: 10px;
        border: 1px solid;
        border-color: var(--accent);
        font-size: large;
        box-shadow: inset 0 0 4px 1px var(--accent), 0 0 10px -5px var(--fg) !important;
    }

    .event-card-id {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        font-size: 14px;
        color: var(--accent);
    }

    .eventSessions {
        display: grid;
        grid-template-columns: 33% 33% 33%;
        scrollbar-gutter: stable both-edges;
        height: 90vh;
        overflow: hidden;
        scroll-timeline: --sessionScroll;

    }



    .eventSessions:has(:not(:hover))::after {
        content: 'hover and scroll down for more ';
        position: absolute;
        bottom: 12px;
        right: 29%;
        /* background: rgba(255, 255, 255, 0.9); */
        background: var(--bg);
        padding: 1px;
        font-size: 17px;
        text-align: center;
        color: var(--accent);
        pointer-events: none;
        width: 15%;
        border-radius: 5px;
        border: 1px solid var(--fg);
        animation: linear fadeAway 2s infinite;
        /* animation-timeline: scroll(); */
        animation-timeline: --sessionScroll;
        animation-range: 90% 100%;
    }

    .eventSessions:hover {
        overflow-y: scroll;
    }

    .eventSessions:hover:after {
        content: '';
        background: none;
        border: none;

    }

    #dataList option {
        background-color: var(--bg);
        color: var(--fg);
    }

    .session-card {
        border: 1px solid var(--accent);
        padding: 15px;
        margin: 10px;
        font-size: medium;
        border-radius: 5px;
        animation: linear fade-in-on-enter--fade-out-on-exit;
        animation-timeline: view();
        box-shadow: inset 0 0 4px 1px var(--accent);
        border-style: inset;
    }

    .session-card:hover {
        box-shadow: inset 0 0 5px 1px var(--accent);
        filter: brightness(1.1);

    }

    .deleteConfirmationPopover {
        width: 35%;
        height: 25%;
        background: var(--bg);
        color: var(--fg);
        border-radius: 5px;
        padding: 10px;
        border: 1px solid var(--accent);
        animation: fadeIn 0.5s linear;
        box-shadow: inset 0 0 4px 1px var(--accent), 0 0 10px -5px var(--fg);
        backdrop-filter: blur(10px);

        position: relative;
        margin-left: auto;
        margin-right: auto;
        min-height: fit-content;

    }

    .popover-body {
        color: var(--accent);
    }

    .slotLocationName {
        word-wrap: none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .slotLocationName:hover {
        overflow: visible;
        white-space: normal;
        word-wrap: break-word;

        :first-child {
            display: none;

        }
    }

    /* .session-card p:first-child {

    } */

    @keyframes fade-in-on-enter--fade-out-on-exit {
        entry 0% {
            opacity: 0;
            transform: translateY(100%);
        }

        entry 100% {
            opacity: 1;
            transform: translateY(0);
        }

        exit 0% {
            opacity: 1;
            transform: translateY(0);
        }

        exit 90% {
            opacity: 0;
            transform: translateY(-100%);
        }
    }

    @keyframes fadeAway {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }

    /* @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    } */
</style>