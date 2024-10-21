<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/21 15:51:01
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
<script src="./functions/displayNextBirthdays.js"></script>
<script>
    var currentMonth = new Date().getMonth();
</script>

<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="dash-main">
                <!-- Start of cards section -->
                <div class="cards-container">
                    <!-- Card 1 -->
                    <div id="websiteStatus" class="dash-card narrow">
                        <div class="card-content">
                            <div class="component-header">Website Status</div>
                            <div id="urlStatus" class="card-content"></div>
                        </div>
                    </div>
                    <!-- End Card 1 -->
                    <!-- Card 2 SSR-->
                    <?php include "./components/recentSeparations.php" ?>
                    <!-- End Card 2 -->
                    <!-- Card 3 SSR-->
                    <?php include "./components/newEmployees.php" ?>
                    <!-- End Card 3 -->
                    <!-- Card 4 SSR-->
                    <?php include "./components/nextHoliday.php" ?>
                    <!-- End Card 4 -->
                    <!-- Card 5 CSR {Pubic Domain API}-->
                    <div class="dash-card narrow short">
                        <div class="card-content">
                            <div class="component-header">Did you know?</div>
                            <div class="fact" id="fact"></div>
                        </div>
                    </div>
                    <!-- End Card 5 -->
                    <!-- Card 6 SSR-->
                    <?php include "./components/employeeAnniversaries.php" ?>
                    <!-- End Card 6 -->
                    <!-- Card 7 -->
                    <div id="birthdays" class="dash-card">
                        <div class="card-content">
                            <div class="component-header-tabs" id="component-header-tabs">
                                <div class="component-header active" id="birthdayTabOne"><button class="not-btn" onclick='swapTabs("birthdayTab1")'><?php echo date("F"); ?> birthdays </button></div>
                                <div class="component-header" id="birthdayTabTwo"><button class="not-btn" onclick='swapTabs("birthdayTab2")'><?php echo date("F", strtotime("+1 month")); ?> birthdays</button></div>
                            </div>
                            <div id="birthdaysContent" class="card-content"></div>
                            <div id="nextBirthdaysContent" class="card-content hidden"></div>
                        </div>
                    </div>
                    <!-- End Card 7 -->
                </div>
            </div>
        </div>
    </div>
    <?php include "./components/footer.php" ?>
</body>

</html>
<script>
    makeWebsiteStatusCards()
    // theDeparted()
    // fetchHoliday()
    // theNewbies()
    // renderAnniversaries()
    renderBirthdays()
    renderNextBirthdays()
</script>

<script>
    function swapTabs(tab) {
        var currentMonthTab = document.getElementById('birthdayTabOne')
        var currentMonthBirthdays = document.getElementById('birthdaysContent')
        var nextMonthTab = document.getElementById('birthdayTabTwo')
        var nextMonthBirthdays = document.getElementById('nextBirthdaysContent')
        if (tab === 'birthdayTab1') {
            currentMonthTab.classList.add('active')
            // currentMonthTab.classList.remove('hidden')
            nextMonthTab.classList.remove('active')
            // nextMonthTab.classList.add('hidden')
            currentMonthBirthdays.classList.remove('hidden')
            nextMonthBirthdays.classList.add('hidden')
        } else if (tab === 'birthdayTab2') {
            // currentMonthTab.classList.add('hidden')
            currentMonthTab.classList.remove('active')
            nextMonthTab.classList.add('active')
            // nextMonthTab.classList.remove('hidden')

            currentMonthBirthdays.classList.add('hidden')
            nextMonthBirthdays.classList.remove('hidden')
        }
    }
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

    .component-header-tabs {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        width: 100%;
        height: 100%;
        /* font-size: medium; */
        text-align: center;
        padding-top: 15px;
    }

    .component-header {
        width: 100%;
    }

    .component-header-tabs {


        /* .component-header:nth-child(1) {
            border-right: 1px solid var(--accent);
        } */

        .component-header:nth-child(2) {
            margin-right: 10px;
        }
    }

    .not-btn {
        color: unset;

    }

    .component-header.active {
        background-color: var(--accent);
        color: light-dark(var(--bg), var(--fg));
        border-radius: 7px;
    }

    /* .active {
        background-color: var(--accent);
        color: var(--fg);
    } */



    /*
    .not-btn.active {
        color: light-dark(var(--fg), var(--fg));
    } */
</style>