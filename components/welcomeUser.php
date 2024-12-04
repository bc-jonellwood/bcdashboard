<?php
// Created: 2024/12/03 13:49:17
// Last modified: 2024/12/04 10:30:02

$html = '
    <section class="masthead" role="img" aria-label="Image Description">
        <h1 class="hero-header">
            Welcome, ' . strtolower($_SESSION['FirstName']) . ' ' . strtolower($_SESSION['LastName']) . '
        </h1>
        <input type="text" class="hero-search" placeholder="Search Coming Soon" />
    </section>
';

echo $html;
?>

<style>
    .hero-header {
        text-transform: capitalize;
    }
</style>