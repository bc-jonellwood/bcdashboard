<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/16 15:10:19
include "./components/header.php"
?>
<script src="./functions/checkURLOnline.js"></script>


<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="dash-main bg-dark">
                <div class="cards-container">
                    <div id="websiteStatus">
                        <h4 class="component-header">Website Status Indicators</h4>
                        <div id="urlStatus"></div>
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
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 20px;
        min-height: fit-content;
        margin-left: auto;
        margin-right: auto;
        /* background-color: light-dark(#5b89a1, #1b283c); */
    }

    .card-title a {
        font-size: large !important;
    }
</style>