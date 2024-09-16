<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/16 11:55:19
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
      const newTheme = localStorage.getItem('bcdash-theme');
      // remove any existing classes based on the secret prefix codewords
      const filteredClasses = classes.filter((cls) => !cls.startsWith('mode') && !cls.startsWith('theme'));

      // add new class with the secret prefix
      filteredClasses.push(`${newMode} ${newTheme}`);

      // set the new class list on the body
      body.className = filteredClasses.join(' ');
    }

    function change_mode(mode) {
      // console.log('mode', mode)
      writeModeToStorage(mode);
      swapBodyClass();
    }

    function change_theme(theme) {
      // console.log('theme', theme)
      writeThemeToStorage(theme);
      swapBodyClass();
      recolorIcons();
    }

    function recolorIcons() {
      const icons = document.querySelectorAll('img[src$=".svg"]');
      // console.log(icons);
      icons.forEach(icon => {
        icon.classList.add('recolor');

      });
      updateSVGFill();
    }


    // function to check if there is a theme in local storage and if not set a default value
    function getThemeFromStorage() {
      const theme = localStorage.getItem('bcdash-theme');
      if (theme) {
        swapBodyClass(theme);
      } else {
        writeThemeToStorage('yellow');
        swapBodyClass('yellow');
      }
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

    // getThemeFromStorage();
    // getModeFromStorage();
    // function to write new theme or mode to local storage
    function writeThemeToStorage(theme) {
      localStorage.setItem('bcdash-theme', 'theme-' + theme);
    }
    // function to write new theme to local storage
    function writeModeToStorage(mode) {
      localStorage.setItem('bcdash-mode', 'mode-' + mode);
    }

    function updateSVGFill() {
      const svgElements = document.querySelectorAll('.recolor');
      // console.log("Here are the SVG Elements")
      // console.log(svgElements);

      svgElements.forEach((element) => {
        const svgContent = element.outerHTML;
        // console.log('SVG Content', svgContent);
        const newContent = svgContent.replace(/fill=".*?"/, `fill="-var(--accent)"`);
        element.outerHTML = newContent;
      });
    }
    // updateSVGFill();

    function setClassAndModeOnLoad() {
      getThemeFromStorage();
      getModeFromStorage();
      // recolorIcons();
      updateSVGFill();
    }


    document.addEventListener('DOMContentLoaded', setClassAndModeOnLoad);
  </script>
</head>
<div class="header">
  <span class="notification-bar">
    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
      <path fill="#000" d="M13.2 10L11 13l-1-1.4L9 13l-2.2-3C3 11 3 13 3 16.9c0 0 3 1.1 6.4 1.1h1.2c3.4-.1 6.4-1.1 6.4-1.1c0-3.9 0-5.9-3.8-6.9m-3.2.7L8.4 10l1.6 1.6l1.6-1.6zm0-8.6c-1.9 0-3 1.8-2.7 3.8S8.6 9.3 10 9.3s2.4-1.4 2.7-3.4c.3-2.1-.8-3.8-2.7-3.8" class="contrast" />
    </svg>
    <!-- <img src="./icons/profile.svg" alt="youve got your profile" width="32" height="32" class="rounded-circle me-2" /> -->
    <button class="not-btn" popovertarget="settings-popover-menu" popovertargetaction="show">
      <!-- <img src="./icons/settings.svg" alt="youve got settings" width="32" height="32" class="rounded-circle me-2" /> -->
      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="1.5" fill="#E3E3E3" />
        <path fill="#000" d="M20.32 9.37h-1.09c-.14 0-.24-.11-.3-.26a.34.34 0 0 1 0-.37l.81-.74a1.63 1.63 0 0 0 .5-1.18a1.67 1.67 0 0 0-.5-1.19L18.4 4.26a1.67 1.67 0 0 0-2.37 0l-.77.74a.38.38 0 0 1-.41 0a.34.34 0 0 1-.22-.29V3.68A1.68 1.68 0 0 0 13 2h-1.94a1.69 1.69 0 0 0-1.69 1.68v1.09c0 .14-.11.24-.26.3a.34.34 0 0 1-.37 0L8 4.26a1.72 1.72 0 0 0-1.19-.5a1.65 1.65 0 0 0-1.18.5L4.26 5.6a1.67 1.67 0 0 0 0 2.4l.74.74a.38.38 0 0 1 0 .41a.34.34 0 0 1-.29.22H3.68A1.68 1.68 0 0 0 2 11.05v1.89a1.69 1.69 0 0 0 1.68 1.69h1.09c.14 0 .24.11.3.26a.34.34 0 0 1 0 .37l-.81.74a1.72 1.72 0 0 0-.5 1.19a1.66 1.66 0 0 0 .5 1.19l1.34 1.36a1.67 1.67 0 0 0 2.37 0l.77-.74a.38.38 0 0 1 .41 0a.34.34 0 0 1 .22.29v1.09A1.68 1.68 0 0 0 11.05 22h1.89a1.69 1.69 0 0 0 1.69-1.68v-1.09c0-.14.11-.24.26-.3a.34.34 0 0 1 .37 0l.76.77a1.72 1.72 0 0 0 1.19.5a1.65 1.65 0 0 0 1.18-.5l1.34-1.34a1.67 1.67 0 0 0 0-2.37l-.73-.73a.34.34 0 0 1 0-.37a.34.34 0 0 1 .29-.22h1.09A1.68 1.68 0 0 0 22 13v-1.94a1.69 1.69 0 0 0-1.68-1.69M12 15.5a3.5 3.5 0 1 1 3.5-3.5a3.5 3.5 0 0 1-3.5 3.5" class="contrast" />
      </svg>

    </button>
    <!-- <img src="./icons/mail.svg" alt="youve got mail" width="32" height="32" class="rounded-circle me-2" /> -->
    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
      <path fill="#000" d="m1.574 5.286l7.5 4.029c.252.135.578.199.906.199s.654-.064.906-.199l7.5-4.029c.489-.263.951-1.286.054-1.286H1.521c-.897 0-.435 1.023.053 1.286m17.039 2.203l-7.727 4.027c-.34.178-.578.199-.906.199s-.566-.021-.906-.199s-7.133-3.739-7.688-4.028C.996 7.284 1 7.523 1 7.707V15c0 .42.566 1 1 1h16c.434 0 1-.58 1-1V7.708c0-.184.004-.423-.387-.219" class="contrast" />
    </svg>
  </span>
</div>

<!-- Settins popover menu -->
<div class="settings-popover-menu" name="settings-popover-menu" id="settings-popover-menu" popover="manual">
  <div class="popover-header">
    <h3>Settings</h3>
    <button type="button" class="btn-x" popovertarget="settings-popover-menu" popovertargetaction="hide" aria-label="Close">X
    </button>
  </div>
  <div class="popover-body">
    <div class="theme-select">
      <section>
        <h4>Select Theme</h4>
        <button class="not-btn color-picker-dot" style="background-color: black;" type="button" value="base" onclick="change_theme(this.value)"> </button>
        <button class="not-btn color-picker-dot" style="background-color: #efdc05;" type="button" value="yellow" onclick="change_theme(this.value)"> </button>
        <button class="not-btn color-picker-dot" style="background-color: #9a48d0;" type="button" value="purple" onclick="change_theme(this.value)"> </button>
        <button class="not-btn color-picker-dot" style="background-color: #005677;" type="button" value="blue" onclick="change_theme(this.value)"> </button>
        <button class="not-btn color-picker-dot" style="background-color: grey;" type="button" value="mono" onclick="change_theme(this.value)"> </button>
    </div>
    </section>
    <section>

      <div class="theme-select">
        <h4>Select Mode</h4>
        <button class="not-btn" onclick="change_mode('light')">
          <img src="./icons/light-mode.svg" alt="light mode" width="32" height="32" class="rounded-circle me-2" />
        </button>
        <button class="not-btn" onclick="change_mode('dark')">
          <img src="./icons/dark-mode.svg" alt="dark mode" width="32" height="32" class="rounded-circle me-2" />
        </button>
      </div>
    </section>
  </div>
</div>
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
    /* background-color: #99bbc9; */
    background-color: light-dark(#99bbc9, #005677);
    ;
    border: 2px solid #005677;
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

  .notification-bar svg {
    height: 40px;
    width: 40px;
  }

  .contrast {
    fill: var(--contrast)
  }
</style>