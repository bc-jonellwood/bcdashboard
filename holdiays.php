<?php
// Created: 2024/12/10 11:37:28
// Last modified: 2024/12/10 11:48:26
include "./components/header.php"
?>



<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <div class="coming-soon-container">
            <h1>Coming Soon</h1>
            <div class="holiday-decorations">
                <img src="images/elves-who-code.jpg" alt="elves who code">
            </div>
        </div>
    </div>

    <?php include './components/footer.php'; ?>
</div>

<style>
    h1 {
        text-align: center;
        font-size: 2rem;
        margin-top: 20px;
    }

    img {
        height: 75dvh;
        width: auto;
        /* width: 100%; */
        /* height: auto; */
        margin-left: auto;
        margin-right: auto;
    }
</style>