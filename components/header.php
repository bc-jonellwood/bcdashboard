<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/27 13:44:34
session_start();


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
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/custom.css">
    <link rel="stylesheet" href="styles/theme.css">

    <script src="./functions/utils.js"></script>
    <script src="./functions/randomAlert.js"></script>
    <script src="./classes/Notification.js"></script>
    <!-- <script src="./functions/renderNotificationText.js"></script> -->
    <!-- <link rel=" stylesheet" href="styles/patternfly.css ">
        < link rel = "stylesheet"
        href = "styles/patternfly-addons.css " > -- >
            <
            !-- < script src = "../functions/displayThemeAndMode.js" >
    </script> -->
    <title>BC Dashboard</title>

    <script>
        // function swapBodyClass(newMode, prefix = 'mode-') {
        // function swapBodyClass(newMode, prefix) {
        //   console.log('Swapping Body Class')
        //   console.log('New Mode:', newMode)
        //   console.log('Prefix:', prefix)
        //   const body = document.body;
        //   const classes = body.className.split(' ');

        //   // remove any existing classes based on the secret prefix codewords
        //   const filteredClasses = classes.filter((cls) => !cls.startsWith(prefix));

        //   // add new class with the secret prefix
        //   filteredClasses.push(`${prefix}${newMode}`);

        //   // set the new class list on the body
        //   body.className = filteredClasses.join(' ');
        // }
        // get the current mode from local storage versus directly passed in
        function swapBodyClass() {
            console.log('Swapping Body Class')
            const body = document.body;
            const classes = body.className.split(' ');

            const newMode = localStorage.getItem('bcdash-mode');
            // const newTheme = localStorage.getItem('bcdash-theme');
            // remove any existing classes based on the secret prefix codewords
            // const filteredClasses = classes.filter((cls) => !cls.startsWith('mode') && !cls.startsWith('theme'));
            const filteredClasses = classes.filter((cls) => !cls.startsWith('mode'));

            // add new class with the secret prefix
            // filteredClasses.push(`${newMode} ${newTheme}`);
            filteredClasses.push(`${newMode}`);

            // set the new class list on the body
            body.className = filteredClasses.join(' ');
        }

        function displayThemeAndMode() {
            // var theme = localStorage.getItem('bcdash-theme');
            var mode = localStorage.getItem('bcdash-mode');
            // console.log('theme and mode', theme, mode);
            // document.getElementById('theme').innerText = theme;
            document.getElementById('mode').innerText = mode;
        }

        function change_mode(mode) {
            // console.log('mode', mode)
            writeModeToStorage(mode);
            swapBodyClass();
            displayThemeAndMode()
        }

        // function change_theme(theme) {
        //     // console.log('theme', theme)
        //     writeThemeToStorage(theme);
        //     swapBodyClass();
        //     //recolorIcons();
        //     displayThemeAndMode()
        // }

        function recolorIcons() {
            const icons = document.querySelectorAll('img[src$=".svg"]');
            console.log('ICONS');
            console.log(icons);
            icons.forEach(icon => {
                //icon.classList.add('recolor');
                icon.style.fill = '#ffffff';

            });
            // updateSVGFill();
        }


        // function to check if there is a theme in local storage and if not set a default value
        // function getThemeFromStorage() {
        //     const theme = localStorage.getItem('bcdash-theme');
        //     if (theme) {
        //         swapBodyClass(theme);
        //     } else {
        //         writeThemeToStorage('yellow');
        //         swapBodyClass('yellow');
        //     }
        // }


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

        // getThemeFromStorage();
        // getModeFromStorage();
        // function to write new theme or mode to local storage
        // function writeThemeToStorage(theme) {
        //     localStorage.setItem('bcdash-theme', 'theme-' + theme);
        // }
        // function to write new theme to local storage
        function writeModeToStorage(mode) {
            localStorage.setItem('bcdash-mode', 'mode-' + mode);
        }

        function updateSVGFill() {
            const svgElements = document.querySelectorAll('.recolor');
            console.log("Here are the SVG Elements")
            console.log(svgElements);

            svgElements.forEach((element) => {
                const svgContent = element.outerHTML;
                // console.log('SVG Content', svgContent);
                const newContent = svgContent.replace(/fill=".*?"/, `fill="-var(--accent)"`);
                element.outerHTML = newContent;
            });
        }


        function setClassAndModeOnLoad() {
            // getThemeFromStorage();
            getModeFromStorage();
            //recolorIcons();
            //updateSVGFill();
        }


        document.addEventListener('DOMContentLoaded', setClassAndModeOnLoad);
    </script>
</head>
<div class="header">
    <div class="hamburger">
        <button popovertarget="sidenav-popover" popovertargetaction="show" class="not-btn menu">
            MENU
        </button>

    </div>
    <span class="notification-bar">
        <div class="notification" id="notification">
            <p class="alert-text" id="alert-text">Alert Alert Alert</p>
        </div>
        <div class="notification-icons">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20" class="recolor">
                <path
                    d="M13.2 10L11 13l-1-1.4L9 13l-2.2-3C3 11 3 13 3 16.9c0 0 3 1.1 6.4 1.1h1.2c3.4-.1 6.4-1.1 6.4-1.1c0-3.9 0-5.9-3.8-6.9m-3.2.7L8.4 10l1.6 1.6l1.6-1.6zm0-8.6c-1.9 0-3 1.8-2.7 3.8S8.6 9.3 10 9.3s2.4-1.4 2.7-3.4c.3-2.1-.8-3.8-2.7-3.8" />
            </svg>
            <!-- <img src="./icons/profile.svg" alt="youve got your profile" width="32" height="32" class="rounded-circle me-2" /> -->
            <button class="not-btn" popovertarget="settings-popover-menu" popovertargetaction="show">
                <!-- <img src="./icons/settings.svg" alt="youve got settings" width="32" height="32" class="rounded-circle me-2" /> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20" class="recolor">
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
        <!-- <div class="theme-select">
            <section>
                <h4>Select Theme</h4>
                <button class="not-btn color-picker-dot" style="background-color: black;" type="button" value="base"
                    onclick="change_theme(this.value)"> </button>
                <button class="not-btn color-picker-dot" style="background-color: #e7de7a;" type="button" value="yellow"
                    onclick="change_theme(this.value)"> </button>
                <button class="not-btn color-picker-dot" style="background-color: var(--purple);" type="button"
                    value="purple" onclick="change_theme(this.value)"> </button>
                <button class="not-btn color-picker-dot" style="background-color: #005677;" type="button" value="blue"
                    onclick="change_theme(this.value)"> </button>
                <button class="not-btn color-picker-dot" style="background-color: grey;" type="button" value="mono"
                    onclick="change_theme(this.value)"> </button>
                <button class="not-btn color-picker-dot" style="background-color: #182825;" type="button" value="brand"
                    onclick="change_theme(this.value)"> </button>
                <button class="not-btn color-picker-dot" style="background-color: var(--simple-dark-background);"
                    type="button" value="simple" onclick="change_theme(this.value)"> </button>
            </section>
        </div> -->
        <section>

            <div class="theme-select">
                <h4>Select Mode</h4>
                <button class="not-btn" onclick="change_mode('light')">
                    <img src="./icons/light-mode-light.svg" alt="light mode" width="32" height="32"
                        class="rounded-circle me-2" />
                </button>
                <button class="not-btn" onclick="change_mode('dark')">
                    <img src="./icons/dark-mode-light.svg" alt="dark mode" width="32" height="32"
                        class="rounded-circle me-2" />
                </button>
            </div>
        </section>
    </div>

</div>
<script>
    async function setAlert() {
        const notification = new Notification();

        const data = await notification.renderNotifcationText().then((data) => {
            if (!data) {
                return;
            }
            //console.log('This is the setAlert function')
            //console.log(data);
            document.getElementById('alert-text').innerText = data.text;
            document.getElementById('notification').classList.add(data.type);
        });
    };


    document.addEventListener('DOMContentLoaded', setAlert());
</script>
<style>
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

        /* background-color: var(--bg); */
        background-color: light-dark(#ddd, #000);
        border: 2px solid;
        border-color: light-dark(#111, #ddd);
        border-radius: 7px;
        color: #000;
        cursor: pointer;

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

    .notification-bar {
        width: 100dvw;
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
        height: 40px;
        width: 40px;
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
        color: var(--accent)
    }

    .menu:hover {
        animation: button-glow 2s infinite !important;
        border-radius: 0px !important;
    }
</style>