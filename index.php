<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/09 12:12:41
include "./components/header.php"
?>
<script src="./functions/checkURLOnline.js"></script>
<script src="./functions/displayRecentlyDeparted.js"></script>
<script src="./functions/renderHoliday.js"></script>
<script src="./functions/fetchHolidays.js"></script>
<script src="./functions/renderEmployeeLookup.js"></script>



<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="dash-main">
                <div class="cards-container">
                    <div id="websiteStatus" class="dash-card narrow">
                        <span class="component-header">Website Status Indicators</span>
                        <div id="urlStatus" class="card-content"></div>
                    </div>
                    <div id="recentSeparations" class="dash-card wide">
                        <span class="component-header">Recent Separations</span>
                        <div id="recentSeparationsContent" class="card-content"></div>
                    </div>
                    <div id="employeeSearchComponent" class="dash-card">
                        <span class="component-header">
                            <div class="employeeSearch" id="employeeSearch"></div>
                        </span>
                    </div>
                    <div id="holidayComponent" class="dash-card narrow short">
                        <span class="component-header">
                            <div class="holiday" id="holiday"></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "./components/footer.php" ?>
</body>

</html>
<script>
    makeWebsiteStatusCards()
    theDeparted()
    fetchHoliday()
    renderEmployeeLookup()
</script>
<!-- <script>
    function dropHandler(ev) {
        ev.preventDefault();
        // Get the id of the target and add the moved element to the target's DOM
        const data = ev.dataTransfer.getData(" application/my-app");
        ev.placeholder.appendChild(document.getElementById(data));
    }

    function dragOverHandler(ev) {
        ev.preventDefault();
        ev.dataTransfer.dropEffect = "move";
    }

    function dragstartHandler(ev) {
        ev.preventDefault();
        // Add the target element's id to the data transfer object
        ev.dataTransfer.setData("text/plain", ev.target.id);
    }

    window.addEventListener("DOMContentLoaded", () => {
        // Get the element by id
        const element = document.getElementById("p1");

        element.dataTransfer.dropEffect = "move";
        // Add the ondragstart event listener
        element.addEventListener("dragstart", dragstartHandler);
    });
</script> -->

<style>
    .dash-main {
        padding: 1rem !important;
        height: 100%;
        display: flex;
    }

    .websiteStatus {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .cards-container {
        width: -webkit-fill-available;
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        grid-template-rows: repeat(6, 1fr);
        grid-gap: 20px;
        min-height: fit-content;
        background-color: light-dark(transparent, var(--black));
        /* margin-left: auto; */
        /* margin-right: auto; */
        /* background-color: light-dark(#5b89a1, #1b283c); */
        padding: 1rem;
    }

    .card-title a {
        font-size: large !important;
    }

    .dash-card {
        padding: 10px;
        grid-column: span 2;
        grid-row: span 2;
        /* background-color: hotpink; */
        /* background-color: light-dark(#5b89a1, #1b283c); */
        color: var(--fg);
        border-radius: 7px;
        /* max-height: 20%; */
        border: 2px solid;
        border-color: light-dark(#000, #ffffff20);
        /* background-color: light-dark(#dee0e3, #000000); */
        background-color: var(--bg);
        box-shadow: 0 0 #0000;
        /* --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 4px 6px -1px #7480ff, 0 2px 4px -2px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); */
        box-shadow: 0 4px 6px -1px #7480ff, 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);

        table {
            font-size: smaller;
            box-shadow: 0 4px 6px -1px #00000010;
            border: 2px solid;
            border-color: light-dark(#00000090, #7480ff);
            background-color: light-dark(#5b89a1, #1b283c);
            /* color: light-dark(#dee0e3, #5b89a1); */
            color: var(--fg);
            border-radius: 5px;
            /* background-color: var(--accent); */
        }
    }

    #urlStatus,
    /* .holiday {
        border: 2px solid;
        border-color: light-dark(#00000090, #7480ff);
        border-radius: 5px;
    } */

    .holiday {
        padding: 5px;
        border-radius: 5px;
        margin: auto;

        p {
            margin: auto;
        }
    }


    /* .card-content {
       
        padding: 5px;
        background-color: var(--bg);

    } */

    .card-content table {
        /* color: light-dark(#000, #dee0e3); */
        /* color: var(--fg); */

        tr th {
            font-size: medium;
        }

        tr td {
            font-size: smaller;
        }
    }

    .wide {
        grid-column: span 3;
    }

    .tall {
        grid-row: span 4;
    }

    .narrow {
        grid-column: span 1;
    }

    .short {
        grid-row: span 1;
    }
</style>