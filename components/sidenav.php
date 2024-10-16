<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/16 13:48:26
?>
<div class="sidenav-popover" popover="manual" name="sidenav-popver" id="sidenav-popover">
    <div class="d-flex flex-column p-3 text-white h-100 sideNavMain"
        style="width: 280px;min-width: -webkit-fill-available;">
        <div class="d-flex w-100 gap-4">
            <img src="./images/jon.png" width="60" alt="fake avatar" class="rounded-circle avatar" />
            <div class="fs-4 center sideNavTitle">Jon's Dashboard</div>
            <button class="btn-x" popovertarget="sidenav-popover" popovertargetaction="hide">X</button>
        </div>

        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="./index.php" class="nav-link d-flex align-items-center" aria-current="page">
                    <img src="./icons/dashboard.svg" class="bi me-2" width="20" height="20" alt="speedometer" />
                    MyDashboard
                </a>

            </li>
            <li>
                <a href="./myLinks.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/link.svg" class="bi me-2" width="20" height="20" alt="link" />
                    MyLinks
                </a>
            </li>
            <li>
                <a href="./myTeam.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/team.svg" alt="my team" class="bi me-2" width="20" height="20">
                    MyTeam
                </a>
            </li>
            <li>
                <a href="./mySignin.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/login.svg" alt="my team" class="bi me-2" width="20" height="20">
                    MySignin
                </a>
            </li>
            <li>
                <a href="./myNotifications.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/bell-ring.svg" alt="my team" class="bi me-2" width="20" height="20">
                    MyNotifications
                </a>
            </li>
            <li>
                <a href="./myEvents.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/calendar-blank.svg" alt="my team" class="bi me-2" width="20" height="20">
                    MyEvents
                </a>
            </li>
            <li>
                <a href="./success.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/party-popper.svg" alt="my success icon" class="bi me-2" width="20" height="20">
                    MySuccess
                </a>
            </li>
            <li>
                <a href="./myDragAndDrop.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/selection-drag.svg" alt="drag and drop icon" class="bi me-2" width="20" height="20">
                    MyDragAndDrop
                </a>
            </li>
            <li>
                <a href="./myQRCode.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/qrcode.svg" alt="qtr code icon" class="bi me-2" width="20" height="20">
                    MyQRCode
                </a>
            </li>
            <li>
                <a href="./myOtherNumbers.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/phone-book.svg" alt="phone book icon" class="bi me-2" width="20" height="20">
                    MyPhoneBook
                </a>
            </li>
            <li>
                <a href="./myAccountRequests.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/account-box.svg" alt="my account request icon" class="bi me-2" width="20" height="20">
                    myAccountRequests
                </a>
            </li>
            <li>
                <a href="./newAccountRequests.php" class="nav-link d-flex align-items-center">
                    <img src="./icons/account-box.svg" alt="my account request icon" class="bi me-2" width="20" height="20">
                    newAccountRequests
                </a>
            </li>
        </ul>

        <!-- <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="./icons/settings.svg" alt="settings icon" width="32" height="32" class="rounded-circle me-2">
                <strong>jon.ellwood</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div> -->
    </div>
</div>

<style>
    .avatar {
        margin-left: auto;
        margin-right: auto;
    }

    /* .sideNavMain {
        background-color: var(--fg);
    } */

    .sidenav-popover {
        height: 100%;
        background-color: var(--accent);
        backdrop-filter: blur(5px);
    }

    .sideNavTitle {
        color: var(--fg)
    }
</style>