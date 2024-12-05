<?php
//Created: 2024/12/05 09:36:35
//Last modified: 2024/12/05 09:56:07

// include_once "./API/dbheader.php";
include "./components/header.php";
include "./components/sidenav.php";

echo "<div class='container-header'>";
echo "<h1>County Connection</h1>";
echo "</div>";
echo "<div class='connection-container'>";
echo "<div class='connection-menu'>";
echo "<p>Menu</p>";
echo "</div>";
echo "<div class='connection-content'>";
echo "<p>Content</p>";
echo "</div>";
echo "</div>";


?>

<style>
    @font-face {
        font-family: Galada;
        src: url('./fonts/Galada.ttf');
    }

    .container-header {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        background-image: url('./images/hero-welcome-bg.png');
    }

    h1 {
        margin: 0 !important;
        padding: 0 !important;
        font-family: Galada;
        font-size: 50px;
        color: var(--bg);
        text-shadow: var(--accent) 1px 0 10px;
    }

    .connection-container {
        margin: 20px;
        display: grid;
        grid-template-columns: 15% 85%;
    }

    .connection-menu {
        border-right: 1px solid var(--accent);
        padding: 20px
    }

    .connection-content {
        padding: 20px;
    }
</style>