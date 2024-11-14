<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/14 09:19:03

// echo session_status();
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
//     // session has just been started, don't check $_SESSION['loggedin'] yet
// } else {
//     if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != 1) {
//         header("Location: mysignin.php");
//     }
// }
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "./components/header.php"
?>
<script>
    let cardIDs = [];

    function minimizeCard(id) {
        // console.log(id)
        cardIDToFromArray(id);
        var card = document.getElementById(id);
        // console.log(card)
        if (card.classList.contains('minimized-dash-card')) {
            card.classList.remove('minimized-dash-card')
        } else {
            card.classList.add('minimized-dash-card')
        }
    }

    function cardIDToFromArray(id) {
        if (cardIDs.includes(id)) {
            cardIDs.splice(cardIDs.indexOf(id), 1);
            localStorage.setItem('bcdash-cardIDs', JSON.stringify(cardIDs));
        } else {
            cardIDs.push(id);
            localStorage.setItem('bcdash-cardIDs', JSON.stringify(cardIDs));
        }
    }

    function applyClassOnLoad() {
        cardIDs = JSON.parse(localStorage.getItem('bcdash-cardIDs'));
        if (cardIDs) {
            for (let i = 0; i < cardIDs.length; i++) {
                let target = document.getElementById(cardIDs[i])
            }
        }
    }
</script>
<script>
    function fakeLoader() {
        showLoader();
        setTimeout(hideLoader, 1200);
    }
    fakeLoader()
</script>
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
                    <?php include "./components/employeeAnniversaries.php"; ?>
                    <?php include "./components/employeeBirthdays.php" ?>
                    <?php include "./components/newEmployees.php" ?>
                    <?php include "./components/recentSeparations.php" ?>
                    <?php include "./components/nextHoliday.php" ?>
                    <?php include "./components/quoteOfTheDay.php" ?>
                    <?php include "./components/show_session.php" ?>
                </div>
            </div>
        </div>
    </div>
    <?php include "./components/footer.php" ?>
</body>

</html>

<script>
    function swapTabs(tab) {
        var currentMonthTab = document.getElementById('birthdayTabOne')
        var currentMonthBirthdays = document.getElementById('birthdaysContent')
        var nextMonthTab = document.getElementById('birthdayTabTwo')
        var nextMonthBirthdays = document.getElementById('nextBirthdaysContent')
        if (tab === 'birthdayTab1') {
            currentMonthTab.classList.add('active')
            nextMonthTab.classList.remove('active')
            currentMonthBirthdays.classList.remove('hidden')
            nextMonthBirthdays.classList.add('hidden')
        } else if (tab === 'birthdayTab2') {
            currentMonthTab.classList.remove('active')
            nextMonthTab.classList.add('active')
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
        /* box-shadow: 0 4px 6px -1px #7480ff, 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); */
        box-shadow: 0 4px 6px -1px var(--accent), 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);

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
    .holiday-date {
        text-align: center;
    }

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
        margin-bottom: auto;
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
        /* font-size: large !important; */
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
        display: flex;
        justify-content: space-evenly;
    }

    .component-header-tabs {

        .component-header:nth-child(2) {
            margin-right: 10px;
        }
    }

    .not-btn {
        color: unset;
    }


    .component-header.active {
        background-color: var(--accent);
        /* color: light-dark(var(--bg), var(--fg)); */
        color: light-dark(var(--fg), var(--bg));
        border-radius: 7px;


    }

    .minimized-dash-card {
        grid-column: span 1;
        grid-row: span 1;
        max-width: 100%;
        max-height: 50px;
        overflow: hidden;
        font-size: medium;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .minimized-dash-card:hover {
        overflow-y: hidden !important;
    }

    .daily-quote {
        font-size: large !important;
    }
</style>