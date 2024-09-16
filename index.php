<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/13 10:20:08
include "./components/header.php" ?>

<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="dash-main bg-dark">

                <h1>My Dashboard</h1>

            </div>
        </div>
    </div>

    <?php include "./components/footer.php" ?>
</body>

</html>


<style>
    .dash-main {
        padding: 1rem !important;
        height: 100%;
        display: flex;
    }
</style>