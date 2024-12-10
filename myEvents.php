<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/09 15:31:25
include "./components/header.php";
?>
<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">


        <form action="./API/addEvent.php" method="POST" id="eventForm">
            <div class="form-group">
                <label for="sEventName">Event Title</label>
                <input type="text" class="form-control" id="sEventName" name="sEventName" required>
                <div class="invalid-feedback">
                    Please provide a valid title.
                </div>
                <small id="eventTitleHelpBlock" class="form-text text-muted help-text">
                    Enter the title of the event.
                </small>
            </div>

            <div class="form-group">
                <label for="sEventDescription">Event Description</label>
                <textarea class="form-control" id="sEventDescription" name="sEventDescription" placeholder="Event Description" required rows="3" maxlength="255"></textarea>
                <div class="invalid-feedback">
                    Please provide a valid description.
                </div>
                <small id="eventDescriptionHelpBlock" class="form-text text-muted help-text">
                    Enter the description of the event. It is limited to 255 characters.
                </small>
            </div>

            <div class="gap-3 form-row col-lg-6 d-flex justify-content-between">
                <div class="mb-3">
                    <label for="dtStartDate">Start Date
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" id="dtStartDate" name="dtStartDate" required>
                            <div class=" invalid-feedback">
                                Please do better.
                            </div>
                        </div>
                    </label>
                </div>


                <div class="mb-3">
                    <label for="dtEndDate">Event End Date</label>
                    <div class="input-group">
                        <input type="datetime-local" class="form-control" id="dtEndDate" name="dtEndDate" required>
                        <div class="invalid-feedback">
                            Please do better.
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group hidden">
                <label for="sEventLocation">Event Location</label>
                <input type="text" class="form-control" id="sEventLocation" name="sEventLocation">
                <div class="invalid-feedback">
                    Please provide a valid location.
                </div>
                <small id="eventLocationHelpBlock" class="form-text text-muted help-text">
                    Enter the location of the event.
                </small>
            </div>

            <div class="form-group">
                <label for="sStatus">Event Status</label>
                <select class="form-control" id="sStatus" name="sStatus" required>
                    <option selected value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <div class="invalid-feedback">
                    Please provide a valid status.
                </div>
                <small id="eventStatusHelpBlock" class="form-text text-muted help-text">
                    Select "Inactive" if want to create the Event but are not ready to allow sign ups. It will have to be updated to Active before it will be available to the public.
                </small>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="validate(event)">Submit</button>
            </div>

        </form>
    </div>

    <div class="content">
        <div id="recentEventsContent" class="recentEventsContent">
            <div id="eventsAgenda"></div>
        </div>
    </div>
</div>
<div class="deleteConfirmationPopover" id="deleteConfirmationPopover" name="deleteConfirmationPopover" popover="manual" name="deleteConfirmationPopover"></div>
<?php include "./components/footer.php" ?>
<script>
    async function validate(e) {
        e.preventDefault();
        // send for data to API with fetch request and await response. When response is received, we will display the response to the user in a div called "step-two"

        const form = document.getElementById("eventForm");
        const response = await fetch("./API/addEvent.php", {
            method: "POST",
            body: new FormData(form)
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = `eventdetails.php?eventID=${data.eventID}`;
        } else {
            alert("Event addition failed");
        }
    }

    function displayEvent(data) {
        var eventDetails = document.getElementById("eventDetails");
        eventDetails.innerHTML = `
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Event ID: ${data.eventID}</h5>
                <p class="card-text">Event Title: ${data.eventTitle}</p>
                <p class="card-text">Event Description: ${data.eventDescription}</p>
                <p class="card-text">Event Location: ${data.eventLocation}</p>
                <p class="card-text">Event Start Date: ${data.eventStartDate}</p>
                <p class="card-text">Event End Date: ${data.eventEndDate}</p>
                <p class="card-text">Event Status: ${data.eventStatus}</p>
            </div>
            <div class="options-card">
                <input type="checkbox" id="cbActive" name="cbActive" ${data.eventStatus == "active" ? "checked" : ""}>
                <label for="cbActive">Active</label>
            </div>
        </div>
        `;
    }
</script>
<script src="./functions/renderEventsAgenda.js"></script>
<script src="./functions/parseDateAndTime.js"></script>
<script src="./functions/createDeleteConfirmationPopover.js"></script>
<script>
    // write this function in the morning to get the events list and render that b 
    async function getEvents() {
        const response = await fetch("./API/getAllEvents.php");
        const data = await response.json();
        //console.log(data);
        renderAgenda(data);
    }
    getEvents();
</script>

<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        display: grid;
        grid-template-columns: 3fr 2fr;
    }

    .card {
        margin: 1rem;
        background-color: var(--bg);
        color: var(--fg);
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .card-title {
        background-color: var(--bg);
        /* color: var(--fg); */
    }

    .content {
        padding: 20px;
        background-color: var(--bg);
    }

    details {
        margin-bottom: 1em;
    }

    .recentEventsContent {
        height: 100vh;
        overflow-y: auto;
        scrollbar-gutter: stable;
        padding-right: 20px;
    }

    .entry {
        display: grid;
        grid-template-columns: 1fr 1fr;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: var(--bg);
        background-clip: border-box;
        border: 1px solid var(--accent);
        border-radius: 0.25rem;
        padding: 1rem;
        margin: 1rem;
        font-size: medium;
    }

    /* .event-description {
        grid-column-start: 1;
        grid-column-end: 3;
    } */

    .event-title {
        border-bottom: 1px dashed var(--accent);
        padding-bottom: 10px;
    }

    .event-title:first-child {
        font-weight: bold;
    }

    .event-title:hover {
        border-bottom: 1px solid var(--accent);
    }

    .event-shifted {
        display: flex;
        gap: 10px;
        text-transform: capitalize;
    }

    .event-shifted p:first-child {
        font-weight: bold;
        margin-top: -6%;
        color: var(--accent);
        padding-bottom: 2%;
        margin-bottom: 2%;
    }

    .event-shifted p:last-child {
        font-weight: bold;
        margin-left: -8%;
        color: var(--fg)
    }

    .col-span-2 {
        grid-column-start: 1;
        grid-column-end: 3;
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
        /* display: block; */
        position: relative;
        margin-left: auto;
        margin-right: auto;
        min-height: fit-content;

    }

    .deleteConfirmationPopover[open] {
        display: block;
    }

    .popover-body {
        color: var(--accent);
        display: inline;
    }

    [popover]:popover-open+.deleteConfirmationPopover {
        display: block;
    }


    /* .event-created-by {
        display: flex;
        gap: 10px;
        text-transform: capitalize;
    }

    .event-created-by p:first-child {
        font-weight: bold;
        margin-top: -4%;
        color: var(--accent);
    }

    .event-created-by p:last-child {
        font-weight: bold;
        margin-left: -8%;
        color: (--fg)
    } */
</style>
<!-- 
http://localhost/bcdashboard/eventDetails.php?eventID=E7880440-69A6-8846-A754-E5E94F1FA7FA -->