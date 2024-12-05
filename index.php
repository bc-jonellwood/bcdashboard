<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/04 15:51:07

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
        var childCard = document.getElementById(id + '-child');
        console.log(childCard);
        // console.log(card)
        if (card.classList.contains('minimized-dash-card')) {
            card.classList.remove('minimized-dash-card')
            childCard.classList.add('hidden')
        } else {
            card.classList.add('minimized-dash-card')
            childCard.classList.remove('hidden')
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

    function fixChris() {
        var list = document.querySelectorAll('itTeamStatusName')
        list.forEach(name => {
            var nameHOlder = name.innerText
            console.log(nameHOlder)
        })
    }
</script>
<script>
    function fakeLoader() {
        showLoader();
        setTimeout(hideLoader, 200);
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
            <?php include "./components/welcomeUser.php" ?>
            <?php include "./components/navBlocks.php" ?>
            <div class="dash-main">
                <!-- Start of cards section -->
                <div class="cards-container">
                    <?php include "./components/employeeAnniversaries.php"; ?>
                    <?php include "./components/employeeBirthdays.php" ?>
                    <?php include "./components/newEmployees.php" ?>
                    <?php include "./components/recentSeparations.php" ?>
                    <?php include "./components/itTeamStatus.php" ?>
                    <?php include "./components/nextHoliday.php" ?>
                    <!-- </?php include "./components/newEmployeesCards.php" ?> -->
                    <!-- </?php include "./components/quoteOfTheDay.php" ?> -->
                    <!-- </?php include "./components/newEmployeesCarousel.php" ?> -->
                </div>
            </div>
        </div>
    </div>
    <?php include "./components/itTeamStatusTicker.php" ?>
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
<!-- carousel  -->
<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const carouselItems = document.querySelectorAll(".carousel-item");
        const moveRightButton = document.getElementById("moveRight");
        const moveLeftButton = document.getElementById("moveLeft");

        // Set the first carousel item to active
        if (carouselItems.length > 0) {
            carouselItems[0].classList.add("active");
        }

        let total = carouselItems.length;
        let current = 0;

        moveRightButton.addEventListener("click", function() {
            let next = current;
            current = current + 1;
            setSlide(next, current);
        });

        moveLeftButton.addEventListener("click", function() {
            let prev = current;
            current = current - 1;
            setSlide(prev, current);
        });

        function setSlide(prev, next) {
            let slide = current;

            if (next > total - 1) {
                slide = 0;
                current = 0;
            }

            if (next < 0) {
                slide = total - 1;
                current = total - 1;
            }

            if (carouselItems[prev]) {
                carouselItems[prev].classList.remove("active");
            }
            if (carouselItems[slide]) {
                carouselItems[slide].classList.add("active");
            }

            setTimeout(function() {
                // Placeholder for any delayed logic
            }, 800);

            console.log("current " + current);
            console.log("prev " + prev);
        }
    });
</script> -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // applyClassOnLoad();
        fixChris();
    });
</script>
<style>
    @font-face {
        font-family: 'Galada';
        src: url('./fonts/Galada.ttf') format('truetype');
    }

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
        /* grid-template-rows: repeat(6, 1fr); */
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
        /* grid-column: span 2; */
        /* grid-row: span 2; */
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

    .medWide {
        grid-column: span 2;
        grid-row: span 1;
    }

    .wide {
        grid-column: span 3;
        grid-row: span 1;
    }

    .tall {
        grid-row: span 4;
    }

    .narrow {
        /* grid-row: span 1; */
        grid-column: span 1;
    }

    .short {
        grid-row: span 1;
    }

    .square {
        grid-column: span 1;
        grid-row: span 1;
        height: 50%;
        overflow: hidden;
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
        display: none;
        position: fixed;
        bottom: 0;
        right: 0;
        max-width: 100%;
        max-height: 50px;
        overflow: hidden;
        font-size: medium;
        padding-left: 0 !important;
        padding-right: 0 !important;
        z-index: 1000;
        /* Ensure it stays on top of other elements */
    }

    .minimized-dash-card.stacked {
        right: initial;
        left: 0;
        bottom: initial;
        top: 0;
    }

    .minimized-dash-card:hover {
        overflow-y: hidden !important;
    }

    .daily-quote {
        font-size: large !important;
    }

    .itTeamStatusTable {
        font-size: unset !important;
        border: none !important;
        width: 100% !important;
    }

    .itTeamStatusItem {
        /* display: flex; */
        vertical-align: middle;
        font-size: medium;
    }

    .status-0 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: green !important;
        color: var(--bg) !important;
    }

    .status-1 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: red !important;
        color: var(--bg) !important;
    }

    .status-2 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: purple !important;
        color: var(--bg) !important;
    }

    .status-3 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: yellow !important;
        color: var(--bg) !important;
    }

    .status-4 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: yellowgreen !important;
        color: var(--bg) !important;
    }

    .status-5 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: darkgreen !important;
        color: var(--bg) !important;
    }

    .status-6 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: darkred !important;
        color: var(--bg) !important;
    }

    .status-7 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: white !important;
        color: var(--bg) !important;
    }

    .status-8 {
        display: flex !important;
        content: "" !important;
        width: 10px !important;
        height: 10px !important;
        border-radius: 100% !important;
        background-color: grey !important;
        color: var(--bg) !important;
    }

    .welcome-hero {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        max-height: 5em;

    }

    .fancy {
        font-family: cursive;
        font-size: x-large;
    }

    .masthead {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        width: 100%;
        height: 25vh;
        /* if you don't want it to take up the full screen, reduce this number */
        overflow: hidden;
        background-size: cover !important;
        background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 36%, rgba(0, 0, 0, 0.65) 100%), url(images/hero-welcome-bg.png) no-repeat center center scroll;
        position: relative;
    }

    .hero-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    .hero-header {
        font-style: normal;
        font-family: Galada;
        font-weight: bold;
        color: #eee;
        font-size: 7vmin;
        letter-spacing: 0.03em;
        line-height: 1;
        text-shadow: 1px 2px 4px rgba(0, 0, 0, 0.8);
        margin-top: 20px;
        position: relative;
        z-index: 2;
    }

    .hero-search {
        width: 50%;
        padding: 10px;
        border-radius: 7px;
        border: 1px solid var(--accent);
        margin-top: 10px;
        background-color: var(--bg);
        color: var(--fg);
        /* font-size: 1.5rem; */
        font-weight: bold;
        text-align: center;
        position: relative;
        z-index: 2;
        margin-bottom: 40px;
    }

    .main {
        display: unset !important;
    }
</style>