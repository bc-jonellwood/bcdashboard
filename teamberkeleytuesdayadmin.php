<?php
// Created: 2024/12/06 10:22:54
// Last modified: 2024/12/06 10:38:10

include "./components/header.php";
include "./components/sidenav.php";
?>
<div class="container-header">
    <h1>Team Berkeley Tuesday</h1>
</div>
<div class="content">
    <form>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Example: Meet Joe Black" required>
        </div>
        <div class="mb-3">
            <label for="department" class="form-label">County Department / Role</label>
            <textarea class="form-control" id="department" name="department" rows="3" placeholder="Example: Joe Black is a waffle engineer at Waffle House."></textarea>
        </div>
        <div class="mb-3">
            <label for="describeYourself" class="form-label">Describe Yourself in Two Words</label>
            <input type="text" class="form-control" id="describeYourself" name="describeYourself" placeholder="Example: Purple Enigma."></input>
        </div>
        <div class="mb-3">
            <label for="favoriteHobby" class="form-label>Favorite Hobby</label>
            <input type=" text" class="form-control" id="favoriteHobby" name="favoriteHobby" placeholder="Example: Knitting kittens."></input>
        </div>
        <div class="mb-3">
            <label for="favoriteOutsideInterest" class="form-label">Favorite Interest Outside of Work</label>
            <textarea class="form-control" id="favoriteOutsideInterest" name="favoriteOutsideInterest" placeholder="Example: Watching paint dry."></textarea>
        </div>
        <div class="mb-3">
            <label for="favoriteShow" class="form-label">Favorite Show to binge Watch</label>
            <input type="text" class="form-control" id="favoriteShow" name="favoriteShow" placeholder="Example: The Office (Joe Black Edition)."></input>
        </div>
        <div class="mb-3">
            <label for="favoriteVacation" class="form-label">Favorite Vacation Spot</label>
            <input type="text" class="form-control" id="favoriteVacation" name="favoriteVacation" placeholder="Example: The Moon."></input>
        </div>
        <div class="mb-3">
            <label for="somethingUnique" class="form-label">Something Unique About You</label>
            <textarea class="form-control" id="somethingUnique" name="somethingUnique" placeholder="Example: I can juggle 3 waffles at once."></textarea>
        </div>
    </form>
</div>

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
</style>