<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2025/01/16 13:59:39
include(dirname(__FILE__) . '/../classes/SidenavItem.php');
// include(dirname(__FILE__) . '/../classes/User.php');
$sidenavItem = new SidenavItem();
$sidenavItems = $sidenavItem->getUserSidenavItems($_SESSION['userID']);

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
            <?php
            if ($sidenavItems) {
                foreach ($sidenavItems as $sidenavItem) {
                    echo "
                    <li class='nav-item'>
                        <a href='" . $sidenavItem['sItemHref'] . "' class='nav-link d-flex align-items-center'>
                            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' class='bi me-2 recolor' width='24' height='24'>
                                <path d='" . $sidenavItem['sItemSvgPath'] . "' />
                            </svg>
                            " . $sidenavItem['sItemText'] . "
                        </a>
                    </li>
                    ";
                }
            }

            ?>
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
    }



    .sideNavTitle {
        color: var(--fg)
    }

    .mysvg {
        transform: rotate(-20deg);
    }

    .sidebar-header {
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