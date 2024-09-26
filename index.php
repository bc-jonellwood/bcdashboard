<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/26 10:39:21
include "./components/header.php"
?>
<script src="./functions/checkURLOnline.js"></script>
<script src="./functions/displayRecentlyDeparted.js"></script>


<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="dash-main">
                <div class="cards-container">
                    <div id="websiteStatus" class="dash-card">
                        <span class="component-header">Website Status Indicators</span>
                        <div id="urlStatus" class="card-content"></div>
                    </div>
                    <div id="recentSeparations" class="dash-card wide">
                        <span class="component-header">Recent Separations</span>
                        <div id="recentSeparationsContent" class="card-content"></div>
                    </div>
                    <div id="placeholder" class="dash-card narrow">
                        <span class="component-header">Narrow Card</span>
                        <my-element></my-element>
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
        /* margin-left: auto; */
        /* margin-right: auto; */
        /* background-color: light-dark(#5b89a1, #1b283c); */
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
        color: light-dark(#dee0e3, #5b89a1);
        border-radius: 7px;
        /* max-height: 20%; */
        border: 2px solid;
        border-color: light-dark(#000, #ffffff20);
        background-color: light-dark(#dee0e3, #000000);
        box-shadow: 0 0 #0000;
        /* --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 4px 6px -1px #7480ff, 0 2px 4px -2px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow); */
        box-shadow: 0 4px 6px -1px #7480ff, 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);

        table {
            font-size: smaller;
            box-shadow: 0 4px 6px -1px #00000010;
            /* background-color: light-dark(#7480ff70, #7480ff40); */
            /* background-color: var(--accent); */
            /* color: var(--bg); */
            /* color: #ddd; */
            /* border-radius: 7px; */
            border: 2px solid;
            border-color: light-dark(#00000090, #7480ff);
            background-color: light-dark(#5b89a1, #1b283c);
            color: light-dark(#dee0e3, #5b89a1);
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
</style>