<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2025/01/02 13:27:53
?>

<div class="sidenav-popover sidenav" popover="manual" name="sidenav-popver" id="sidenav-popover">
    <div class="d-flex flex-column p-1 sideNavMain"
        style="width: 20rem;min-width: -webkit-fill-available;">
        <div class="d-flex w-100 gap-4 align-items-center justify-content-evenly">
            <div class="sidebar-header">
                <a href="/index.php" class="d-flex align-items-center text-white text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="50">
                        <text x="7" y="49" font-family="Brush Script MT, cursive" font-size="70" class="recolor mysvg">my</text>
                    </svg>
                    <div class="fs-4 center sideNavTitle">dashboard</div>
                </a>
                <button class="not-btn" popovertarget="sidenav-popover" popovertargetaction="hide" type="button" id="sidenavCloseBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M19,3H16.3H7.7H5A2,2 0 0,0 3,5V7.7V16.4V19A2,2 0 0,0 5,21H7.7H16.4H19A2,2 0 0,0 21,19V16.3V7.7V5A2,2 0 0,0 19,3M15.6,17L12,13.4L8.4,17L7,15.6L10.6,12L7,8.4L8.4,7L12,10.6L15.6,7L17,8.4L13.4,12L17,15.6L15.6,17Z" />
                    </svg>
                </button>
                <button class="not-btn pin-button" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24" id="pin">
                        <path d="M16,12V4H17V2H7V4H8V12L6,14V16H11.2V22H12.8V16H18V14L16,12Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor hidden" width="24" height="24" id="unpin">
                        <path d="M2,5.27L3.28,4L20,20.72L18.73,22L12.8,16.07V22H11.2V16H6V14L8,12V11.27L2,5.27M16,12L18,14V16H17.82L8,6.18V4H7V2H17V4H16V12Z" />
                    </svg>
                </button>
            </div>
        </div>

        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/index.php" class="nav-link d-flex align-items-center" aria-current="page">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M21,16V4H3V16H21M21,2A2,2 0 0,1 23,4V16A2,2 0 0,1 21,18H14V20H16V22H8V20H10V18H3C1.89,18 1,17.1 1,16V4C1,2.89 1.89,2 3,2H21M5,6H14V11H5V6M15,6H19V8H15V6M19,9V14H15V9H19M5,12H9V14H5V12M10,12H14V14H10V12Z" />
                    </svg>
                    Home
                </a>

            </li>
            <li>
                <a href="/links/index.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
                    </svg>
                    Links
                </a>
            </li>
            <li>
                <a href="/myteam.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C7.4,22 3.55,18.92 2.36,14.73L6.19,16.31C6.45,17.6 7.6,18.58 8.97,18.58C10.53,18.58 11.8,17.31 11.8,15.75V15.62L15.2,13.19H15.28C17.36,13.19 19.05,11.5 19.05,9.42C19.05,7.34 17.36,5.65 15.28,5.65C13.2,5.65 11.5,7.34 11.5,9.42V9.47L9.13,12.93L8.97,12.92C8.38,12.92 7.83,13.1 7.38,13.41L2,11.2C2.43,6.05 6.73,2 12,2M8.28,17.17C9.08,17.5 10,17.13 10.33,16.33C10.66,15.53 10.28,14.62 9.5,14.29L8.22,13.76C8.71,13.58 9.26,13.57 9.78,13.79C10.31,14 10.72,14.41 10.93,14.94C11.15,15.46 11.15,16.04 10.93,16.56C10.5,17.64 9.23,18.16 8.15,17.71C7.65,17.5 7.27,17.12 7.06,16.67L8.28,17.17M17.8,9.42C17.8,10.81 16.67,11.94 15.28,11.94C13.9,11.94 12.77,10.81 12.77,9.42A2.5,2.5 0 0,1 15.28,6.91C16.67,6.91 17.8,8.04 17.8,9.42M13.4,9.42C13.4,10.46 14.24,11.31 15.29,11.31C16.33,11.31 17.17,10.46 17.17,9.42C17.17,8.38 16.33,7.53 15.29,7.53C14.24,7.53 13.4,8.38 13.4,9.42Z" />
                    </svg>
                    My Team
                </a>
            </li>

            <li>
                <a href="/mysignature.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M22,22H2V20H22V22M2.26,16.83L5.09,14L2.26,11.17L3.67,9.76L6.5,12.59L9.33,9.76L10.74,11.17L7.91,14L10.74,16.83L9.33,18.24L6.5,15.41L3.67,18.24L2.26,16.83Z" />
                    </svg>
                    My Signature
                </a>
            </li>
            <li>
                <a href="/mynotifications.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21M19.75,3.19L18.33,4.61C20.04,6.3 21,8.6 21,11H23C23,8.07 21.84,5.25 19.75,3.19M1,11H3C3,8.6 3.96,6.3 5.67,4.61L4.25,3.19C2.16,5.25 1,8.07 1,11Z" />
                    </svg>
                    Notifications
                </a>
            </li>
            <li>
                <a href="/myevents.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M19 3H18V1H16V3H8V1H6V3H5C3.89 3 3 3.9 3 5V19C3 20.11 3.9 21 5 21H19C20.11 21 21 20.11 21 19V5C21 3.9 20.11 3 19 3M19 19H5V9H19V19M19 7H5V5H19V7Z" />
                    </svg>
                    Events
                </a>
            </li>
            <!-- <li>
                <a href="./success.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M14.53 1.45L13.45 2.53L15.05 4.13C15.27 4.38 15.38 4.67 15.38 5S15.27 5.64 15.05 5.86L11.5 9.47L12.5 10.55L16.13 6.94C16.66 6.35 16.92 5.7 16.92 5C16.92 4.3 16.66 3.64 16.13 3.05L14.53 1.45M10.55 3.47L9.47 4.55L10.08 5.11C10.3 5.33 10.41 5.63 10.41 6S10.3 6.67 10.08 6.89L9.47 7.45L10.55 8.53L11.11 7.92C11.64 7.33 11.91 6.69 11.91 6C11.91 5.28 11.64 4.63 11.11 4.03L10.55 3.47M21 5.06C20.31 5.06 19.67 5.33 19.08 5.86L13.45 11.5L14.53 12.5L20.11 6.94C20.36 6.69 20.66 6.56 21 6.56S21.64 6.69 21.89 6.94L22.5 7.55L23.53 6.47L22.97 5.86C22.38 5.33 21.72 5.06 21 5.06M7 8L2 22L16 17L7 8M19 11.06C18.3 11.06 17.66 11.33 17.06 11.86L15.47 13.45L16.55 14.53L18.14 12.94C18.39 12.69 18.67 12.56 19 12.56S19.64 12.69 19.89 12.94L21.5 14.53L22.55 13.5L20.95 11.86C20.36 11.33 19.7 11.06 19 11.06Z" />
                    </svg> Success
                </a>
            </li> -->
            <li>
                <a href="/facilitiesrequestsubmit.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M22.7,19L13.6,9.9C14.5,7.6 14,4.9 12.1,3C10.1,1 7.1,0.6 4.7,1.7L9,6L6,9L1.6,4.7C0.4,7.1 0.9,10.1 2.9,12.1C4.8,14 7.5,14.5 9.8,13.6L18.9,22.7C19.3,23.1 19.9,23.1 20.3,22.7L22.6,20.4C23.1,20 23.1,19.3 22.7,19Z" />
                    </svg>
                    New Facilities Request
                </a>
            </li>
            <li>
                <a href="/mp/index.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M18.9 6C18.7 5.4 18.1 5 17.5 5H6.5C5.8 5 5.3 5.4 5.1 6L3 12V20C3 20.5 3.5 21 4 21H5C5.6 21 6 20.5 6 20V19H18V20C18 20.5 18.5 21 19 21H20C20.5 21 21 20.5 21 20V12L18.9 6M6.8 7H17.1L18.2 10H5.8L6.8 7M19 17H5V12H19V17M7.5 13C8.3 13 9 13.7 9 14.5S8.3 16 7.5 16 6 15.3 6 14.5 6.7 13 7.5 13M16.5 13C17.3 13 18 13.7 18 14.5S17.3 16 16.5 16C15.7 16 15 15.3 15 14.5S15.7 13 16.5 13Z" />
                    </svg>
                    Motor Pool
                </a>
            </li>
            <!-- <li>
                <a href="/mydraganddrop.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M14,17H17V14H19V17H22V19H19V22H17V19H14V17M12,17V19H9V17H12M7,17V19H3V15H5V17H7M3,13V10H5V13H3M3,8V4H7V6H5V8H3M9,4H12V6H9V4M15,4H19V8H17V6H15V4M19,10V12H17V10H19Z" />
                    </svg>
                    Drag And Drop
                </a>
            </li> -->
            <li>
                <a href="/myqrcode.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M3,11H5V13H3V11M11,5H13V9H11V5M9,11H13V15H11V13H9V11M15,11H17V13H19V11H21V13H19V15H21V19H19V21H17V19H13V21H11V17H15V15H17V13H15V11M19,19V15H17V19H19M15,3H21V9H15V3M17,5V7H19V5H17M3,3H9V9H3V3M5,5V7H7V5H5M3,15H9V21H3V15M5,17V19H7V17H5Z" />
                    </svg>
                    QR Code
                </a>
            </li>
            <li>
                <a href="/myothernumbers.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M12 21.5C10.65 20.65 8.2 20 6.5 20C4.85 20 3.15 20.3 1.75 21.05C1.65 21.1 1.6 21.1 1.5 21.1C1.25 21.1 1 20.85 1 20.6V6C1.6 5.55 2.25 5.25 3 5C4.11 4.65 5.33 4.5 6.5 4.5C8.45 4.5 10.55 4.9 12 6C13.45 4.9 15.55 4.5 17.5 4.5C18.67 4.5 19.89 4.65 21 5C21.75 5.25 22.4 5.55 23 6V20.6C23 20.85 22.75 21.1 22.5 21.1C22.4 21.1 22.35 21.1 22.25 21.05C20.85 20.3 19.15 20 17.5 20C15.8 20 13.35 20.65 12 21.5M11 7.5C9.64 6.9 7.84 6.5 6.5 6.5C5.3 6.5 4.1 6.65 3 7V18.5C4.1 18.15 5.3 18 6.5 18C7.84 18 9.64 18.4 11 19V7.5M13 19C14.36 18.4 16.16 18 17.5 18C18.7 18 19.9 18.15 21 18.5V7C19.9 6.65 18.7 6.5 17.5 6.5C16.16 6.5 14.36 6.9 13 7.5V19M14 16.35C14.96 16 16.12 15.83 17.5 15.83C18.54 15.83 19.38 15.91 20 16.07V14.57C19.13 14.41 18.29 14.33 17.5 14.33C16.16 14.33 15 14.5 14 14.76V16.35M14 13.69C14.96 13.34 16.12 13.16 17.5 13.16C18.54 13.16 19.38 13.24 20 13.4V11.9C19.13 11.74 18.29 11.67 17.5 11.67C16.22 11.67 15.05 11.82 14 12.12V13.69M14 11C14.96 10.67 16.12 10.5 17.5 10.5C18.41 10.5 19.26 10.59 20 10.78V9.23C19.13 9.08 18.29 9 17.5 9C16.18 9 15 9.15 14 9.46V11Z" />
                    </svg>
                    Phone Book
                </a>
            </li>
            <li>
                <a href="/countyconnection.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24" class="bi me-2 recolor">
                        <path d="M10 2c-1.11 0-2 .89-2 2v3c0 1.11.89 2 2 2h1v2H2v2h4v2H5c-1.11 0-2 .89-2 2v3c0 1.11.89 2 2 2h4c1.11 0 2-.89 2-2v-3c0-1.11-.89-2-2-2H8v-2h8v2h-1c-1.11 0-2 .89-2 2v3c0 1.11.89 2 2 2h4c1.11 0 2-.89 2-2v-3c0-1.11-.89-2-2-2h-1v-2h4v-2h-9V9h1c1.11 0 2-.89 2-2V4c0-1.11-.89-2-2-2zm0 2h4v3h-4zM5 17h4v3H5zm10 0h4v3h-4z" />
                    </svg>
                    County Connection
                </a>
            </li>
            <li>
                <a href="/pioadmin.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24" class="bi me-2 recolor">
                        <path d="M12,3C13.74,3 15.36,3.5 16.74,4.35C17.38,3.53 18.38,3 19.5,3A3.5,3.5 0 0,1 23,6.5C23,8 22.05,9.28 20.72,9.78C20.9,10.5 21,11.23 21,12A9,9 0 0,1 12,21A9,9 0 0,1 3,12C3,11.23 3.1,10.5 3.28,9.78C1.95,9.28 1,8 1,6.5A3.5,3.5 0 0,1 4.5,3C5.62,3 6.62,3.53 7.26,4.35C8.64,3.5 10.26,3 12,3M12,5A7,7 0 0,0 5,12A7,7 0 0,0 12,19A7,7 0 0,0 19,12A7,7 0 0,0 12,5M16.19,10.3C16.55,11.63 16.08,12.91 15.15,13.16C14.21,13.42 13.17,12.54 12.81,11.2C12.45,9.87 12.92,8.59 13.85,8.34C14.79,8.09 15.83,8.96 16.19,10.3M7.81,10.3C8.17,8.96 9.21,8.09 10.15,8.34C11.08,8.59 11.55,9.87 11.19,11.2C10.83,12.54 9.79,13.42 8.85,13.16C7.92,12.91 7.45,11.63 7.81,10.3M12,14C12.6,14 13.13,14.19 13.5,14.5L12.5,15.5C12.5,15.92 12.84,16.25 13.25,16.25A0.75,0.75 0 0,0 14,15.5A0.5,0.5 0 0,1 14.5,15A0.5,0.5 0 0,1 15,15.5A1.75,1.75 0 0,1 13.25,17.25C12.76,17.25 12.32,17.05 12,16.72C11.68,17.05 11.24,17.25 10.75,17.25A1.75,1.75 0 0,1 9,15.5A0.5,0.5 0 0,1 9.5,15A0.5,0.5 0 0,1 10,15.5A0.75,0.75 0 0,0 10.75,16.25A0.75,0.75 0 0,0 11.5,15.5L10.5,14.5C10.87,14.19 11.4,14 12,14Z" />
                    </svg>
                    PIO Admin
                </a>
            </li>

            <li>
                <a href="/newaccountrequests.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M16.5,16.25C16.5,14.75 13.5,14 12,14C10.5,14 7.5,14.75 7.5,16.25V17H16.5M12,12.25A2.25,2.25 0 0,0 14.25,10A2.25,2.25 0 0,0 12,7.75A2.25,2.25 0 0,0 9.75,10A2.25,2.25 0 0,0 12,12.25Z" />
                    </svg>
                    Account Requests
                </a>
            </li>
            <li>
                <a href="/printshop/index.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6M20 6L12 11L4 6H20M20 18H4V8L12 13L20 8V18Z" />
                    </svg>
                    Print Shop
                </a>
            </li>
            <li>
                <a href="/ua/index.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M13.2 10L11 13l-1-1.4L9 13l-2.2-3C3 11 3 13 3 16.9c0 0 3 1.1 6.4 1.1h1.2c3.4-.1 6.4-1.1 6.4-1.1c0-3.9 0-5.9-3.8-6.9m-3.2.7L8.4 10l1.6 1.6l1.6-1.6zm0-8.6c-1.9 0-3 1.8-2.7 3.8S8.6 9.3 10 9.3s2.4-1.4 2.7-3.4c.3-2.1-.8-3.8-2.7-3.8" />
                    </svg>
                    User Management
                </a>
            </li>
            <!-- <li>
                <a href="/usermanagementemaillayout.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6M20 6L12 11L4 6H20M20 18H4V8L12 13L20 8V18Z" />
                    </svg>
                    Better User Mgmt
                </a>
            </li> -->
            <hr class='sidenav-hr'>
            <li>
                <a href="/signout.php" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                        <path d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z" />
                    </svg>
                    Signout
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidenav = document.getElementById('sidenav-popover');
        const pinSvg = document.getElementById('pin');
        const unpinSvg = document.getElementById('unpin');
        const sidenavCloseBtn = document.getElementById('sidenavCloseBtn');
        const sidenavPopover = document.getElementById('sidenav-popover');
        let allowHover = localStorage.getItem('bcdash-sidebarHover') === 'true' ? true : false;
        let isPinned = false;
        let hoverTimeout;

        // function applyAllowHover() {
        //     var allowHoverSetting = localStorage.getItem('bcdash-sidebarHover');
        //     if(allowHoverSetting) {
        //         allowHover = allowHoverSetting === 'true';
        //     } else {
        //         localStorage.setItem('bcdash-sidebarHover', 'true');
        //     }
        // }

        function showSidenav() {
            console.log('showing sidenav');
            sidenav.classList.add('visible');
            sidenav.showPopover();
            if (!isPinned) {
                document.body.style.marginLeft = `${sidenav.offsetWidth}px`;
            }
        }

        function showAndPinSidenav() {
            isPinned = true;
            sidenav.classList.add('visible');
            sidenav.showPopover();
            pinSvg.classList.add('hidden');
            unpinSvg.classList.remove('hidden');
            document.body.style.marginLeft = `${sidenav.offsetWidth}px`;
        }

        function hideSidenav() {
            if (!isPinned) {
                sidenav.hidePopover();
                sidenav.classList.remove('visible');
                document.body.style.marginLeft = '0';
            }
        }

        function hideAndUnpinSidenav() {
            // const sidenavPopover = document.getElementById('sidenav-popover');
            sidenav.hidePopover();
            isPinned = false;
            sidenav.classList.remove('visible');
            document.body.style.marginLeft = '0';
            pinSvg.classList.remove('hidden');
            unpinSvg.classList.add('hidden');
        }

        function pinSidenav() {
            isPinned = !isPinned;
            if (isPinned) {
                pinSvg.classList.add('hidden');
                unpinSvg.classList.remove('hidden');
                document.body.style.marginLeft = `${sidenav.offsetWidth}px`;
                localStorage.setItem('bcdash-sidnav-pinned', 'true');
            } else {
                pinSvg.classList.remove('hidden');
                unpinSvg.classList.add('hidden');
                localStorage.setItem('bcdash-sidnav-pinned', 'false');
                hideSidenav();
            }
        }

        function checkLocalStorageForPinned() {
            var pinnedInLocal = localStorage.getItem('bcdash-sidnav-pinned');
            if (pinnedInLocal) {
                if (localStorage.getItem('bcdash-sidnav-pinned') === 'true') {
                    // pinSidenav();
                    // showSidenav();
                    showAndPinSidenav();
                } else {
                    hideSidenav();
                }
            } else {
                localStorage.setItem('bcdash-sidnav-pinned', 'false');
            }
        }
        // if (allowHover === true) {
        document.body.addEventListener('mousemove', function(event) {
            if (localStorage.getItem('bcdash-sidebarHover') === 'true') {
                if (event.clientX < 50) {
                    console.log(event.clientX);
                    hoverTimeout = setTimeout(showSidenav, 500);
                } else if (!sidenav.matches(':hover')) {
                    clearTimeout(hoverTimeout);
                    if (!isPinned) {
                        hideSidenav();
                    }
                }
            }
        });

        sidenav.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
        });

        sidenav.addEventListener('mouseleave', function() {
            if (!isPinned) {
                hideSidenav();
            }
        });
        // }
        sidenav.querySelector('.pin-button').addEventListener('click', pinSidenav);
        sidenavCloseBtn.addEventListener('click', hideAndUnpinSidenav);
        checkLocalStorageForPinned();
        // (localStorage.getItem('bcdash-sidnav-pinned') === 'true' ? pinSidenav() : hideSidenav());
    });
</script>

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
        font-size: smaller;
    }

    #mp-anchor {
        anchor-name: --mpAnchor;
    }

    .mp-popover {
        position: fixed;
        position-anchor: --mpAnchor;
        /* left: anchor(--mpAnchor right); */
        height: max-content;
        background-color: var(--bg);
        border: 2px solid;
        border-color: var(--accent);
        border-radius: 7px;
        color: var(--fg);
        cursor: pointer;
        width: min-content;
        backdrop-filter: blur(5px);
        font-size: smaller;
        /* block-size: 100vb; */
        inline-size: 15vi;
        inset-inline-start: 0;
        inset-inline-end: unset;

        .popover-header {
            background-color: var(--accent);
        }

        /* &:popover-open {
            translate: 0;
            transition-timing-function: ease-out;
        } */


        /* @starting-style {
            &:popover-open {
                translate: -100%
            }
        } */
    }



    .sideNavTitle {
        color: var(--fg)
    }

    .mysvg {
        transform: rotate(-20deg);
    }

    .sidebar-header {
        /* background-color: hotpink; */
        display: flex;
        flex-direction: row;
    }

    .sidenav {
        transition: transform 0.3s ease;
        transform: translateX(-100%);
    }

    .sidenav.visible {
        transition: transform 0.2s ease;
        transform: translateX(0);
    }
</style>