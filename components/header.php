<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/20 10:29:33

if (!isset($_SESSION)) {
    session_start();
};
// if (session_status() == PHP_SESSION_NONE) {
// session_start();
// session has just been started, don't check $_SESSION['loggedin'] yet
// }

// if (session_status() == PHP_SESSION_NONE) {
//     // session has just been started, don't check $_SESSION['loggedin'] yet
// } else {
///////////////////////++++++++++++++++++++++++++
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != 1) {
    header("Location: mysignin.php");
}
////////////////////////////////+++++++++++++++++
// }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://unpkg.com/imask"></script>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/custom.css">
    <link rel="stylesheet" href="styles/theme.css">
    <!-- <link rel="stylesheet" href="styles/teams.css"> -->

    <script src="./functions/utils.js"></script>
    <script src="./functions/randomAlert.js"></script>
    <script src="./classes/Notification.js"></script>
    <script src="./functions/loader.js"></script>
    <script src="./functions/renderEmployeeLookup.js"></script>
    <script src="./functions/renderDepartmentLookup.js"></script>
    <script src="./functions/renderPhoneLookup.js"></script>
    <script src="./functions/renderQuickLinks.js"></script>
    <!-- favicon -->
    <link rel="icon" href="favicons/favicon.ico">
    <title>BC Dashboard</title>

    <script>
        function swapBodyClass() {
            const body = document.body;
            const classes = body.className.split(' ');

            const newMode = localStorage.getItem('bcdash-mode');
            const filteredClasses = classes.filter((cls) => !cls.startsWith('mode'));

            // add new class with the secret prefix
            filteredClasses.push(`${newMode}`);

            // set the new class list on the body
            body.className = filteredClasses.join(' ');
        }

        function displayThemeAndMode() {
            var mode = localStorage.getItem('bcdash-mode');
            document.getElementById('mode').innerText = mode;
        }

        function change_mode(mode) {
            writeModeToStorage(mode);
            swapBodyClass();
            displayThemeAndMode()
        }


        function recolorIcons() {
            const icons = document.querySelectorAll('img[src$=".svg"]');
            icons.forEach(icon => {
                icon.style.fill = '#ffffff';
            });
        }

        // function to check if there is a mode in local storage and if not set a default value
        function getModeFromStorage() {
            const mode = localStorage.getItem('bcdash-mode');
            if (mode) {
                swapBodyClass(mode, 'mode-');
            } else {
                writeModeToStorage('dark');
                swapBodyClass('dark');
            }
        }

        // function to write new theme to local storage
        function writeModeToStorage(mode) {
            localStorage.setItem('bcdash-mode', 'mode-' + mode);
        }

        function updateSVGFill() {
            const svgElements = document.querySelectorAll('.recolor');

            svgElements.forEach((element) => {
                const svgContent = element.outerHTML;
                const newContent = svgContent.replace(/fill=".*?"/, `fill="-var(--accent)"`);
                element.outerHTML = newContent;
            });
        }

        function setClassAndModeOnLoad() {
            getModeFromStorage();
        }


        document.addEventListener('DOMContentLoaded', setClassAndModeOnLoad);
    </script>

</head>

<div class="header">
    <div class="hamburger">
        <button popovertarget="sidenav-popover" popovertargetaction="show" class="not-btn menu menu-btn">
            ||MENU||
        </button>
    </div>
    <span class="notification-bar">
        <div class="notification" id="notification">
            <p class="alert-text" id="alert-text"></p>
        </div>
        <div class="notification-date">
            <?php echo $_SESSION['loggedinuser'] ?>
        </div>
        <div class="notification-date"><?php include "./components/dateAndTimeDisplay.php" ?></div>
        <div class="notification-icons">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20" class="recolor" id="account-icon">
                <path
                    d="M13.2 10L11 13l-1-1.4L9 13l-2.2-3C3 11 3 13 3 16.9c0 0 3 1.1 6.4 1.1h1.2c3.4-.1 6.4-1.1 6.4-1.1c0-3.9 0-5.9-3.8-6.9m-3.2.7L8.4 10l1.6 1.6l1.6-1.6zm0-8.6c-1.9 0-3 1.8-2.7 3.8S8.6 9.3 10 9.3s2.4-1.4 2.7-3.4c.3-2.1-.8-3.8-2.7-3.8" />
            </svg>
            <!-- <img src="./icons/profile.svg" alt="youve got your profile" width="32" height="32" class="rounded-circle me-2" /> -->
            <button class="not-btn" popovertarget="settings-popover-menu" popovertargetaction="show">
                <!-- <img src="./icons/settings.svg" alt="youve got settings" width="32" height="32" class="rounded-circle me-2" /> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 23 23" class="recolor">
                    <circle cx="12" cy="12" r="1.5" />
                    <path
                        d="M20.32 9.37h-1.09c-.14 0-.24-.11-.3-.26a.34.34 0 0 1 0-.37l.81-.74a1.63 1.63 0 0 0 .5-1.18a1.67 1.67 0 0 0-.5-1.19L18.4 4.26a1.67 1.67 0 0 0-2.37 0l-.77.74a.38.38 0 0 1-.41 0a.34.34 0 0 1-.22-.29V3.68A1.68 1.68 0 0 0 13 2h-1.94a1.69 1.69 0 0 0-1.69 1.68v1.09c0 .14-.11.24-.26.3a.34.34 0 0 1-.37 0L8 4.26a1.72 1.72 0 0 0-1.19-.5a1.65 1.65 0 0 0-1.18.5L4.26 5.6a1.67 1.67 0 0 0 0 2.4l.74.74a.38.38 0 0 1 0 .41a.34.34 0 0 1-.29.22H3.68A1.68 1.68 0 0 0 2 11.05v1.89a1.69 1.69 0 0 0 1.68 1.69h1.09c.14 0 .24.11.3.26a.34.34 0 0 1 0 .37l-.81.74a1.72 1.72 0 0 0-.5 1.19a1.66 1.66 0 0 0 .5 1.19l1.34 1.36a1.67 1.67 0 0 0 2.37 0l.77-.74a.38.38 0 0 1 .41 0a.34.34 0 0 1 .22.29v1.09A1.68 1.68 0 0 0 11.05 22h1.89a1.69 1.69 0 0 0 1.69-1.68v-1.09c0-.14.11-.24.26-.3a.34.34 0 0 1 .37 0l.76.77a1.72 1.72 0 0 0 1.19.5a1.65 1.65 0 0 0 1.18-.5l1.34-1.34a1.67 1.67 0 0 0 0-2.37l-.73-.73a.34.34 0 0 1 0-.37a.34.34 0 0 1 .29-.22h1.09A1.68 1.68 0 0 0 22 13v-1.94a1.69 1.69 0 0 0-1.68-1.69M12 15.5a3.5 3.5 0 1 1 3.5-3.5a3.5 3.5 0 0 1-3.5 3.5" />
                </svg>

            </button>
            <!-- <img src="./icons/mail.svg" alt="youve got mail" width="32" height="32" class="rounded-circle me-2" /> -->
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20" class="recolor">
                <path
                    d="m1.574 5.286l7.5 4.029c.252.135.578.199.906.199s.654-.064.906-.199l7.5-4.029c.489-.263.951-1.286.054-1.286H1.521c-.897 0-.435 1.023.053 1.286m17.039 2.203l-7.727 4.027c-.34.178-.578.199-.906.199s-.566-.021-.906-.199s-7.133-3.739-7.688-4.028C.996 7.284 1 7.523 1 7.707V15c0 .42.566 1 1 1h16c.434 0 1-.58 1-1V7.708c0-.184.004-.423-.387-.219" />
            </svg>
        </div>
    </span>
</div>

<!-- Settins popover menu -->
<div class="settings-popover-menu" name="settings-popover-menu" id="settings-popover-menu" popover="manual">
    <div class="popover-header">
        <h3>Settings</h3>
        <button type="button" class="btn-x" popovertarget="settings-popover-menu" popovertargetaction="hide"
            aria-label="Close">X
        </button>

    </div>
    <div class="popover-body">
        <section>

            <div class="theme-select">
                <h4>Select Mode</h4>

                <button class="not-btn" onclick="change_mode('light')">
                    <!-- <img src="./icons/light-mode-light.svg" alt="light mode" width="32" height="32"
                        class="rounded-circle me-2 recolor" /> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 22 22" class="recolor">
                        <path d="M12 17q-2.075 0-3.537-1.463T7 12t1.463-3.537T12 7t3.538 1.463T17 12t-1.463 3.538T12 17m-7-4H1v-2h4zm18 0h-4v-2h4zM11 5V1h2v4zm0 18v-4h2v4zM6.4 7.75L3.875 5.325L5.3 3.85l2.4 2.5zm12.3 12.4l-2.425-2.525L17.6 16.25l2.525 2.425zM16.25 6.4l2.425-2.525L20.15 5.3l-2.5 2.4zM3.85 18.7l2.525-2.425L7.75 17.6l-2.425 2.525z" />
                    </svg>
                </button>
                <button class="not-btn" onclick="change_mode('dark')">
                    <!-- <img src="./icons/dark-mode-light.svg" alt="dark mode" width="32" height="32"
                        class="rounded-circle me-2" /> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 22 22" class="recolor">
                        <path d="M12 21q-3.75 0-6.375-2.625T3 12t2.625-6.375T12 3q.35 0 .688.025t.662.075q-1.025.725-1.638 1.888T11.1 7.5q0 2.25 1.575 3.825T16.5 12.9q1.375 0 2.525-.613T20.9 10.65q.05.325.075.662T21 12q0 3.75-2.625 6.375T12 21" />
                    </svg>
                </button>
            </div>
        </section>
        <section>
            <label for="status-select" class="status-select">Update Status:</label>
            <select name="status-select" id="status-select">
                <option value="0">Available</option>
                <option value="1">Not in the office</option>
                <option value="2">Personal Leave</option>
                <option value="3">Lunch</option>
                <option value="4">On the Floor Call cell</option>
                <option value="5">At another building</option>
                <option value="6">Offsite Coverage</option>
            </select>
            <p>TODO: Make the users current status be the selected option.</p>
        </section>
    </div>
</div>
<div class="employee-lookup-popover" id="employeeLookupPopover" popover="manual" name="employeeLookupPopover">
    <div class="card-content dash-card">
        <div class="component-header">Employee Lookup</div>
        <div class="employeeSearch" id="employeeSearch">
            <div class="employee-lookup">
                <div class="employee-lookup-body">
                    <div class="employee-lookup-card">
                        <div class="employee-lookup-card-body">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control employee-lookup-input" id="employee-lookup-first-name" placeholder="First Name">
                                <input type="text" class="form-control employee-lookup-input" id="employee-lookup-last-name" placeholder="Last Name">
                                <button class="btn btn-success" type="button" id="button-addon2" onclick="lookupEmployee()">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="employee-lookup-results-card">
                        <div class="employee-lookup-results-card-body">
                            <div id="employee-lookup-results" class="employee-lookup-results">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="popover-btn-holder">
                <button class="btn btn-danger btn-small employee-lookup-clear-btn" type="button" popovertarget="employeeLookupPopover" popovertargetaction="hide">Make</button>
                <button class="btn btn-secondary btn-small employee-lookup-clear-btn" type="button" onclick="clearEmployeeLookup()">Hate</button>
            </div>
        </div>
    </div>
</div>
<div class="department-lookup-popover" id="departmentLookupPopover" popover="manual" name="departmentLookupPopover">
    <div class="card-content dash-card">
        <div class="component-header">Department Lookup</div>
        <div class="departmentSearch" id="departmentSearch"></div>
    </div>
</div>
<div class="phone-lookup-popover" id="phoneLookupPopover" popover="manual" name="phoneLookupPopover">
    <div class="card-content dash-card">
        <div class="component-header">Phone Lookup</div>
        <div class="phoneSearch" id="phoneSearch"></div>
    </div>
</div>
<div class="quick-links-popover" id="quickLinksPopover" popover="manual" name="quickLinksPopover">
    <div class="card-content dash-card quickLinks">
        <div class="component-header">
            <button type="button" class="btn btn-danger btn-small" popovertarget="quickLinksPopover" popovertargetaction="hide"
                aria-label="Close">Close
            </button>
        </div>
        <div class="quickLinksMenu" id="quickLinksMenu"></div>
    </div>
</div>
<div class="loader-container-overlay hidden" id="loader-container-overlay">
    <div class="loader loader1"></div>
    <div class="loader loader2"></div>
    <div class="loader loader3"></div>
    <div class="loader loader4"></div>
    <div class="loader loader5"></div>
    <div class="loader loader6"></div>
</div>
<div id="logout-menu" class="logout-menu hidden">
    <div>
        <button type="button" class="btn-x" onclick="logout()">Logout</button>
    </div>
</div>
<?php include "./components/toolbar.php" ?>
<script>
    async function setAlert() {
        const notification = new Notification();

        const data = await notification.renderNotifcationText().then((data) => {
            if (!data) {
                return;
            }
            document.getElementById('alert-text').innerText = data.text;
            document.getElementById('notification').classList.add(data.type);
        });
    };


    document.addEventListener('DOMContentLoaded', setAlert());
</script>


<script>
    function renderLookups() {
        renderEmployeeLookup()
        renderDepartmentLookup()
        renderPhoneLookup()
        loadLinks()
    }
    document.addEventListener('DOMContentLoaded', renderLookups);

    // var accountIcon = document.getElementById('account-icon');
    // accountIcon.addEventListener('mouseenter', function() {
    //     var accountMenu = document.getElementById('logout-menu');
    //     accountMenu.classList.remove('hidden');
    // });
    // accountIcon.addEventListener('mouseleave', function() {
    //     setTimeout(function() {
    //         var accountMenu = document.getElementById('logout-menu');
    //         accountMenu.classList.add('hidden');
    //     }, 1000)
    // })
</script>
<style>
    .quick-links-popover[popover],
    .phone-lookup-popover[popover],
    .department-lookup-popover[popover],
    .employee-lookup-popover[popover],
    .settings-popover-menu[popover] {
        transition:
            display 0.3s allow-discrete,
            overlay 0.3s allow-discrete,
            opacity 0.3s,
            translate 0.3s;
        transition-timing-function: ease-in;
        translate: 100%;
        block-size: 100vb;
        inline-size: 20vi;
        inset-inline-start: unset;
        inset-inline-end: 0;
        margin-right: 8px;
        margin-left: 8px;
        margin-top: 8px;
        margin-bottom: 8px;
        padding: 8px;
        border-radius: 8px;

        background-color: light-dark(#ddd, #000);
        border: 2px solid;
        border-color: light-dark(#111, #ddd);
        border-radius: 7px;
        color: #000;
        cursor: pointer;
        overflow-x: hidden;

        &:popover-open {
            translate: 0;
            transition-timing-function: ease-out;
        }

        .color-picker-dot {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin: 5px;
            border: 1px solid #000;
            cursor: pointer;
        }

        @starting-style {
            &:popover-open {
                translate: 100%
            }
        }
    }

    .employee-lookup-popover .dash-card {
        max-height: fit-content !important;
    }

    .quick-links-popover[popover] {
        inline-size: 15vi !important;
        block-size: 90vh !important;
    }

    .quickLinks {
        max-height: 90vh;
    }

    #quickLinksPopover>div {
        max-height: 90vh !important;
    }

    #quickLinks ul li {
        list-style-type: none !important;
        font-size: smaller !important;
        padding: 0;
        margin: 0;
        color: var(--fg);
        padding: 2px;
        /* background-color: var(--bg); */
    }

    #quickLinks ul li:hover {
        background-color: var(--accent);
        color: var(--bg);
        border-radius: 2px;
        padding: 3px;
    }

    .sidenav-popover[popover] {
        transition:
            display 0.3s allow-discrete,
            overlay 0.3s allow-discrete,
            opacity 0.3s,
            translate 0.3s;
        transition-timing-function: ease-in;
        translate: -100%;
        block-size: 100vb;
        inline-size: 20vi;
        inset-inline-start: 0;
        inset-inline-end: unset;
        margin-right: 8px;
        margin-left: 8px;
        margin-top: 8px;
        margin-bottom: 8px;
        padding: 8px;
        border-radius: 8px;

        background-color: var(--bg);
        /* background-color: light-dark(#ddd, #000); */
        border: 2px solid;
        border-color: light-dark(#111, #ddd);
        border-radius: 7px;
        color: var(--fg);
        cursor: pointer;

        &:popover-open {
            translate: 0;
            transition-timing-function: ease-out;
        }


        @starting-style {
            &:popover-open {
                translate: -100%
            }
        }
    }

    .quick-links-popover[popover],
    .phone-lookup-popover[popover],
    .department-lookup-popover[popover],
    .employee-lookup-popover[popover] {
        block-size: 90vb;
        inline-size: 30vi;
    }



    .notification-bar {
        width: 90dvw;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 7px;
        margin: 2px;
        border: solid 2px;
        border-color: light-dark(#000, #ffffff20);
        background-color: var(--bg);
        /* filter: invert(1); */
        padding-right: 20px;
    }

    .notification-icons {
        display: flex;
        justify-content: space-evenly;
        width: 10%;
        flex-direction: row;
        align-items: center;
        background-color: transparent;
        /* filter: invert(.7); */
    }

    .notification-bar:hover {

        border: 10px solid;
        border-image-slice: 1;
        border-width: 2px;
        /* border-image-source: linear-gradient(to left, #743ad5, #d53a9d); */
        border-image-source: linear-gradient(to left, #03A9F4, #05DB6C);
    }


    .notification-bar svg {
        height: 36px;
        width: 36px;
        /* margin: 2px; */
        fill: var(--contrast);
        /* filter: invert(1); */
    }

    .notification {
        display: flex;
        align-items: center;
        color: var(--fg);
        width: 90%;
        border-radius: 7px;
        font-weight: 600;
        padding: 5px;
        border: none;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        margin: 2px;
        background-color: var(--bg);
    }

    .contrast {
        fill: var(--contrast)
    }

    .alert-text {
        margin-bottom: 0 !important;
        padding-left: 20px;
        font-weight: bold;
    }

    .alert {
        background-color: light-dark(#AB1212, #7A0000);
        color: light-dark(#fff, #dddddd);
    }

    .warning {
        background-color: light-dark(orange, #805300);
        color: light-dark(#000, #fff);
    }

    .information {
        background-color: light-dark(blue, #0000A3);
        color: light-dark(#F1FFF0, #dee0e3)
    }

    .other {
        background-color: green;
    }

    @keyframes button-glow {
        0% {
            box-shadow: 0px 0px 36px -10px var(--button-glow-dark);
        }

        50% {
            box-shadow: 0px 0px 36px -10px var(--button-glow-light);
        }

        100% {
            box-shadow: 0px 0px 36px -10px var(--button-glow-dark);
        }
    }


    .menu {
        color: var(--accent);
        vertical-align: center;
        height: 36px;

    }

    .menu:hover {
        /* animation: button-glow 2s infinite !important; */
        border-radius: 0px !important;
    }

    .menu-image {
        max-width: 36%;
        margin-left: auto;
        margin-right: auto;

    }

    .menu-image:hover {
        animation: button-glow 2s infinite !important;
        border-radius: 0px !important;

    }

    .logout-menu {
        display: flex;
        position: fixed;
        top: 0;
        right: 0;
        margin-right: 140px;
        margin-top: 60px;
        z-index: 1000;
        background-color: var(--bg);
        border-radius: 7px;
        border: 1px solid var(--accent);
        color: var(--fg);
        padding: 10px;
        font-size: 18px;

    }

    .hidden {
        display: none;
    }

    /* .toolbar-icon:hover {
    } */
    .menu-btn {
        color: var(--accent) !important;
    }

    .notification-date {
        font-size: small;
        color: var(--accent);
        text-align: right;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        align-content: center;
        width: 5%;
        /* width: fit-content; */
    }

    .popover-btn-holder {
        margin-bottom: 10px;
    }

    .status-select {
        color: var(--fg);
        font-size: 1.5rem;
        margin-left: 10px;
    }
</style>