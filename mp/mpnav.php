<div class='mpnav'>
    <button class='btn btn-sm btn-info' popovertarget='mpadminmenu' popovertargetaction='show'>Admin</button>
    </button>
    <button class='btn btn-sm btn-info' popovertarget='mp-popover' popovertargetaction='show'>Admin</button>
    </button>
    <!-- <div id='mpadminmenu' popover class='mpadminmenu-popover'>
        <div class='close-btn-holder'>
            <button class='not-btn' popovertarget='mpadminmenu' popovertargetaction='hide'>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                    <path d="M19,3H16.3H7.7H5A2,2 0 0,0 3,5V7.7V16.4V19A2,2 0 0,0 5,21H7.7H16.4H19A2,2 0 0,0 21,19V16.3V7.7V5A2,2 0 0,0 19,3M15.6,17L12,13.4L8.4,17L7,15.6L10.6,12L7,8.4L8.4,7L12,10.6L15.6,7L17,8.4L13.4,12L17,15.6L15.6,17Z"></path>
                </svg>
            </button>
        </div>
        <div class='popover-content'>
            <ul>
                <li>
                    <a href='/mp/mpvehicles.php'>Manage Vehicles</a>
                </li>
                <li>
                    <a href='/mp/mpreservations.php'>Mange Reservations</a>
                </li>
            </ul>
            <!-- <a href="/mp/mplocations.php">Locations</a> -->
    <!-- <a href="/mp/mpemployees.php">Employees</a> -->
    <!-- </div>
    </div> -->
</div>
<div id="mp-popover" class="mp-popover" popover="manual">
    <div class="popover-header">
        <button class="btn-close" aria-label="Close" popovertarget="mp-popover" popovertargetaction="hide"></button>
    </div>
    <div class="popover-body">
        <div class="d-flex flex-column align-items-center">
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="/mp/index.php" class="nav-link d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                            <path d="M9.61 16.11C9.61 14.03 10.59 12.19 12.1 11H5L6.5 6.5H17.5L18.72 10.16C19.56 10.53 20.3 11.07 20.91 11.74L18.92 6C18.72 5.42 18.16 5 17.5 5H6.5C5.84 5 5.28 5.42 5.08 6L3 12V20C3 20.55 3.45 21 4 21H5C5.55 21 6 20.55 6 20V19H10.29C9.86 18.13 9.61 17.15 9.61 16.11M6.5 16C5.67 16 5 15.33 5 14.5S5.67 13 6.5 13 8 13.67 8 14.5 7.33 16 6.5 16M20.71 20.7L20.7 20.71L20.71 20.7M16.11 11.61C18.61 11.61 20.61 13.61 20.61 16.11C20.61 17 20.36 17.82 19.92 18.5L23 21.61L21.61 23L18.5 19.93C17.8 20.36 17 20.61 16.11 20.61C13.61 20.61 11.61 18.61 11.61 16.11S13.61 11.61 16.11 11.61M16.11 13.61C14.73 13.61 13.61 14.73 13.61 16.11S14.73 18.61 16.11 18.61 18.61 17.5 18.61 16.11 17.5 13.61 16.11 13.61" />
                        </svg>
                        New Reservation
                    </a>
                </li>
                <li>
                    <a href="/mp/mpreservations.php" class="nav-link d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                            <path d="M8,11L9.5,6.5H18.5L20,11M18.5,16A1.5,1.5 0 0,1 17,14.5A1.5,1.5 0 0,1 18.5,13A1.5,1.5 0 0,1 20,14.5A1.5,1.5 0 0,1 18.5,16M9.5,16A1.5,1.5 0 0,1 8,14.5A1.5,1.5 0 0,1 9.5,13A1.5,1.5 0 0,1 11,14.5A1.5,1.5 0 0,1 9.5,16M19.92,6C19.71,5.4 19.14,5 18.5,5H9.5C8.86,5 8.29,5.4 8.08,6L6,12V20A1,1 0 0,0 7,21H8A1,1 0 0,0 9,20V19H19V20A1,1 0 0,0 20,21H21A1,1 0 0,0 22,20V12L19.92,6M14.92,3C14.71,2.4 14.14,2 13.5,2H4.5C3.86,2 3.29,2.4 3.08,3L1,9V17A1,1 0 0,0 2,18H3A1,1 0 0,0 4,17V12.91C3.22,12.63 2.82,11.77 3.1,11C3.32,10.4 3.87,10 4.5,10H4.57L5.27,8H3L4.5,3.5H15.09L14.92,3Z" />
                        </svg>
                        Manage Reservations
                    </a>
                </li>

                <li>
                    <a href="/mp/mpvehicles.php" class="nav-link d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                            <path d="M20.96 16.45C20.97 16.3 21 16.15 21 16V16.5L20.96 16.45M11 16C11 16.71 11.15 17.39 11.42 18H6V19C6 19.55 5.55 20 5 20H4C3.45 20 3 19.55 3 19V11L5.08 5C5.28 4.42 5.84 4 6.5 4H17.5C18.16 4 18.72 4.42 18.92 5L21 11V16C21 13.24 18.76 11 16 11S11 13.24 11 16M8 13.5C8 12.67 7.33 12 6.5 12S5 12.67 5 13.5 5.67 15 6.5 15 8 14.33 8 13.5M19 10L17.5 5.5H6.5L5 10H19M22.87 21.19L18.76 17.08C19.17 16.04 18.94 14.82 18.08 13.97C17.18 13.06 15.83 12.88 14.74 13.38L16.68 15.32L15.33 16.68L13.34 14.73C12.8 15.82 13.05 17.17 13.93 18.08C14.79 18.94 16 19.16 17.05 18.76L21.16 22.86C21.34 23.05 21.61 23.05 21.79 22.86L22.83 21.83C23.05 21.65 23.05 21.33 22.87 21.19Z" />
                        </svg>
                        Manage Vehicles
                    </a>
                </li>
                <li>
                    <a href="/mptest/index.html" class="nav-link d-flex align-items-center" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="bi me-2 recolor" width="24" height="24">
                            <path d="M4 2A2 2 0 0 0 2 4V12H4V8H6V12H8V4A2 2 0 0 0 6 2H4M4 4H6V6H4M22 15.5V14A2 2 0 0 0 20 12H16V22H20A2 2 0 0 0 22 20V18.5A1.54 1.54 0 0 0 20.5 17A1.54 1.54 0 0 0 22 15.5M20 20H18V18H20V20M20 16H18V14H20M5.79 21.61L4.21 20.39L18.21 2.39L19.79 3.61Z" />
                        </svg>
                        </svg>
                        Drivers Test
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<style>
    .mpnav {
        position: relative;
        left: 0;
        margin-left: 20px;
    }

    .mp-popover[popover],
    .mpadminmenu-popover[popover] {
        transition: display 0.3s allow-discrete,
            overlay 0.3s allow-discrete,
            opacity 0.3s,
            translate 0.3s;
        transition-timing-function: ease-in;
        translate: -100%;
        block-size: max-content;
        /* inline-size: 20vi; */
        inset-inline-start: 0;
        inset-inline-end: unset;

        border-radius: 8px;
        background-color: var(--bg);

        border: 2px solid;
        border-color: light-dark(#111, #ddd);
        border-radius: 7px;
        color: var(--fg);
        cursor: pointer;
        width: max-content;
        padding: 0.5rem;
        font-size: large;
        display: flex;
        flex-direction: column;

        .close-btn-holder {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }


        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
    }

    [popover]:open {
        backdrop-filter: blur(10px);
    }
</style>