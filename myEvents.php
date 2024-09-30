<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/30 15:50:17
include "./components/header.php";
?>
<div class="main">
    <?php include "./components/sidenav.php" ?>
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

        <div class="form-group">
            <label for="sEventLocation">Event Location</label>
            <input type="text" class="form-control" id="sEventLocation" name="sEventLocation" required>
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
                Select "Inactive" if want to create the Event but are not ready to commit to it being displayed. It will have to be updated to Active before it will be displayed.
            </small>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-primary" onclick="validate(event)">Submit</button>
        </div>

    </form>

    <div id="eventDetails"></div>
</div>

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
            alert("Event added successfully");
            console.log(data.eventID);
            displayEvent(data);
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
        </div>
        `;
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
</style>