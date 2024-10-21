<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/21 13:19:46
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
//     header("location: mySignin.php");
//     exit;
// }
$_SESSION['loggedin'] = true;
$_SESSION['username'] = 'jon.ellwood';

if ((isset($_SESSION['loggedin']) == false || $_SESSION['loggedin'] != true) && str_contains(basename($_SERVER['PHP_SELF']), "logout") == false) {
    header("Location: mySignin.php");
}

include "./components/header.php"
?>
<script src="./functions/checkURLOnline.js"></script>
<script src="./functions/displayRecentlyDeparted.js"></script>
<script src="./functions/displayRecentlyHired.js"></script>
<script src="./functions/renderHoliday.js"></script>
<script src="./functions/fetchHolidays.js"></script>
<script src="./functions/quoteOfTheDay.js"></script>
<script src="./functions/displayAnniversaries.js"></script>
<script src="./functions/displayBirthdays.js"></script>

<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="dash-main">
                <div class="cards-container">
                    <div id="websiteStatus" class="dash-card narrow">
                        <div class="card-content">
                            <div class="component-header">Website Status</div>
                            <div id="urlStatus" class="card-content"></div>
                        </div>
                    </div>
                    <div id="recentSeparations" class="dash-card">
                        <div class="card-content">
                            <div class="component-header">Recent Separations</div>
                            <div id="recentSeparationsContent" class="card-content"></div>
                        </div>
                    </div>
                    <div id="recentHired" class="dash-card">
                        <div class="card-content">
                            <div class="component-header">Recent Hires</div>
                            <div id="recentHiredContent" class="card-content"></div>
                        </div>
                    </div>

                    <div id="holidayComponent" class="dash-card narrow short">
                        <div class="card-content">
                            <div class="component-header">Next Holiday</div>
                            <div class="holiday" id="holiday"></div>
                        </div>
                    </div>
                    <div class="dash-card narrow short">
                        <div class="card-content">
                            <div class="component-header">Did you know?</div>
                            <div class="fact" id="fact"></div>
                        </div>
                    </div>
                    <div id="anniversaries" class="dash-card wide">
                        <div class="card-content">
                            <div class="component-header">This months anniversaries</div>
                            <div id="anniversariesContent" class="card-content"></div>
                        </div>
                    </div>
                    <div id="birthdays" class="dash-card">
                        <div class="card-content">
                            <div class="component-header">This months birthdays</div>
                            <div id="birthdaysContent" class="card-content"></div>
                        </div>
                    </div>
                    <!-- <div id="server_session" class="dash-card">
                        <div class="card-content">
                            <div class="component-header">Session Data</div>
                            <div id="sessionData" class="card-content">
                                <?php //print_r($_SESSION) 
                                ?>
                            </div>
                        </div>
                    </div> -->
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
    theNewbies()
    renderAnniversaries()
    renderBirthdays()
</script>

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
        padding: 1rem;
    }

    .card-title a {
        font-size: large !important;
    }

    .dash-card {
        padding: 10px;
        grid-column: span 2;
        grid-row: span 2;
        color: var(--fg);
        border-radius: 7px;
        border: 2px solid;
        border-color: light-dark(#000, #ffffff20);
        background-color: var(--bg);
        box-shadow: 0 0 #0000;
        box-shadow: 0 4px 6px -1px #7480ff, 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);

        table {
            font-size: smaller;
            box-shadow: 0 4px 6px -1px #00000010;
            border: 2px solid;
            border-color: light-dark(#00000090, #7480ff);
            color: var(--fg);
            border-radius: 5px;

        }
    }

    #urlStatus,
    .holiday {
        padding: 5px;
        border-radius: 5px;
        margin: auto;

        p {
            margin: auto;
        }
    }

    .days-until-holiday,
    .holiday-name,
    .holiday-date,
    .fact {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        font-size: medium;
        text-align: center;
        padding-top: 15px;
    }

    .holiday,
    .fact {
        border-top: 1px dashed var(--accent)
    }

    .holiday {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        font-size: medium;
        text-align: center;
        padding-top: 15px;
        white-space: nowrap;
        word-break: keep-all;

    }


    .card-content table {
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