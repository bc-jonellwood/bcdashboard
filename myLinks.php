<?php
// Crated: 2024/09/12 13:12:49
// Last modified: 2024/12/11 15:19:06

include "./components/header.php"

?>
<script src="./functions/makeLinkCard.js"></script>

<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <div class="links-main">
            <div class="links-cards links-cards-1" id="links-cards-1">
                <div class="links-card-header">
                    <div class="ring-around">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 32 32"
                            class="recolor">
                            <path d="M28.523 23.813c-.518-.51-6.795-2.938-7.934-3.396c-1.133-.45-1.585-1.697-1.585-1.697s-.51.282-.51-.51c0-.793.51.51 1.02-2.548c0 0 1.415-.397 1.134-3.68h-.34s.85-3.51 0-4.698c-.853-1.188-1.187-1.98-3.06-2.548c-1.87-.567-1.19-.454-2.548-.396c-1.36.057-2.492.793-2.492 1.188c0 0-.85.057-1.188.397c-.34.34-.906 1.924-.906 2.32s.283 3.06.566 3.624l-.337.11c-.283 3.284 1.132 3.682 1.132 3.682c.51 3.058 1.02 1.755 1.02 2.548c0 .792-.51.51-.51.51s-.453 1.246-1.585 1.697c-1.132.453-7.416 2.887-7.927 3.396c-.51.52-.453 2.896-.453 2.896h26.954s.063-2.378-.453-2.897zm-6.335 2.25h-4.562v-1.25h4.562z" />
                        </svg>
                    </div>
                    <p class="link-card-title">Employee Services</p>
                </div>
                <div id="emp"></div>
            </div>
            <div class="links-cards links-cards-2" id="links-cards-2">
                <div class="links-card-header">
                    <div class="ring-around">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24"
                            class="recolor">
                            <path
                                d="M9 5a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c2.67 0 8 1.34 8 4v2H1v-2c0-2.66 5.33-4 8-4m7.76-9.64c2.02 2.2 2.02 5.25 0 7.27l-1.68-1.69c.84-1.18.84-2.71 0-3.89zM20.07 2c3.93 4.05 3.9 10.11 0 14l-1.63-1.63c2.77-3.18 2.77-7.72 0-10.74z" />
                        </svg>
                    </div>
                    <p class="link-card-title">Communications</p>
                </div>
                <div id="com"></div>
            </div>
            <div class="links-cards links-cards-3" id="links-cards-3">
                <div class="links-card-header">
                    <div class="ring-around">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24"
                            class="recolor">
                            <path
                                d="M6 20q-.825 0-1.412-.587T4 18t.588-1.412T6 16t1.413.588T8 18t-.587 1.413T6 20m6 0q-.825 0-1.412-.587T10 18t.588-1.412T12 16t1.413.588T14 18t-.587 1.413T12 20m6 0q-.825 0-1.412-.587T16 18t.588-1.412T18 16t1.413.588T20 18t-.587 1.413T18 20M6 14q-.825 0-1.412-.587T4 12t.588-1.412T6 10t1.413.588T8 12t-.587 1.413T6 14m6 0q-.825 0-1.412-.587T10 12t.588-1.412T12 10t1.413.588T14 12t-.587 1.413T12 14m6 0q-.825 0-1.412-.587T16 12t.588-1.412T18 10t1.413.588T20 12t-.587 1.413T18 14M6 8q-.825 0-1.412-.587T4 6t.588-1.412T6 4t1.413.588T8 6t-.587 1.413T6 8m6 0q-.825 0-1.412-.587T10 6t.588-1.412T12 4t1.413.588T14 6t-.587 1.413T12 8m6 0q-.825 0-1.412-.587T16 6t.588-1.412T18 4t1.413.588T20 6t-.587 1.413T18 8" />
                        </svg>
                    </div>
                    <p class="link-card-title">Applications</p>
                </div>
                <div id="app"></div>
            </div>
        </div>
    </div>
    <?php include "./components/footer.php" ?>
</div>

<script src="./functions/renderQuickLinks.js"></script>

<script>
    function loadLinksForPage(type) {
        // console.log('type', type);
        const cachedData = JSON.parse(localStorage.getItem(cacheKey));
        // console.log('cachedData');
        // console.log(cachedData);
        cachedData.links.forEach(link => {
            if (link.sClass === type) {
                // console.log('***link***');
                // console.log(link);
                let i;
                createLinkCard(link.sLinkId, link.sHref, link.sIcon, link.sText, type, i);
                i++;
            }
        });
    }
    loadLinksForPage('emp');
    loadLinksForPage('com');
    loadLinksForPage('app');
</script>

<style>
    .links-main {
        height: 100%;
        display: flex;
        flex-direction: row;
        gap: 15px;
        justify-content: center;
        min-width: --webkit-fill-available;
        border-radius: 7px;
    }

    #links-card-holder {
        display: grid;
        grid-template-columns: 33% 33% 33%;
        gap: 15px;
        min-height: fit-content;
        min-width: --webkit-fill-available;
        border-radius: 7px;
        background-color: light-dark(var(--white), var(--black));
        filter: brightness(0.8);
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
        padding: 15px;
    }

    @keyframes glow {
        0% {
            box-shadow: 0px 0px 36px -10px var(--dark-glow);
        }

        50% {
            box-shadow: 0px 0px 36px -10px var(--light-glow);
        }

        100% {
            box-shadow: 0px 0px 36px -10px var(--dark-glow);
        }
    }

    @keyframes glowRed {
        0% {
            box-shadow: 0px 0px 36px -10px var(--dark-fire);
        }

        50% {
            box-shadow: 0px 0px 36px -10px var(--light-red);
        }

        100% {
            box-shadow: 0px 0px 36px -10px var(--dark-fire);
        }
    }

    .links-cards {
        width: 23dvi;
        padding: 20px;
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
        border: 2px solid;

        .links-card-header {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            align-content: center;
            flex-wrap: wrap;


            .ring-around {
                width: 15%;
                border-radius: 50%;
                background-image: linear-gradient(to right, #03A9F4, #05DB6C);
                padding: 5px;
                margin-left: 10px;
                margin-right: auto;
                box-shadow: 0px 0px 36px -10px rgba(0, 255, 255, 0.8), inset 0px 0px 10px 1px rgba(10, 10, 10, 0.2);
                cursor: pointer;
                border: 2px solid #03A9F4;
                animation: glow 2s infinite;
                transition: all 0.3s ease-in-out;
            }

            .ring-around:hover {
                box-shadow: 0px 0px 36px -10px rgba(255, 10, 10, 0.2);
                background-image: linear-gradient(to left, #03A9F4, #05DB6C)
            }


            img {
                width: 99%;
                background-color: black;
                border-radius: 50%;
            }

            svg {
                width: 99%;
                height: 99%;
                background-color: light-dark(#000000, #bbbbbb);
                border-radius: 50%;
            }

        }
    }

    .link-card-title {
        margin-bottom: 0 !important;
        padding-right: 4rem;
    }

    .link-card {
        margin: 2px;
        margin-bottom: 10px;
        background-color: light-dark(#5b89a1, #1b283c);
        color: light-dark(#dee0e3, #5b89a1);
        padding: 10px;
        border-radius: 7px;
        border: 2px solid transparent;

        a {
            display: flex;
            justify-content: space-between;


            .left {
                color: light-dark(var(--white), var(--white));
                display: flex;
                align-items: center;
                gap: 10px;

                p {
                    margin: 0 !important;
                }
            }
        }

    }

    .link-card:hover {
        border: 10px solid;
        border-image-slice: 1;
        border-width: 2px;
        border-image-source: linear-gradient(to left, #03A9F4, #05DB6C);
        border-radius: 7px;
    }

    .recolor {
        fill: var(--accent) !important;
    }

    .st2,
    .st3,
    .st4,
    .st5,
    .st6 {
        fill: #e3e3e3 !important;
    }

    .favorite-star {
        margin-right: 10px;
    }

    .favorite-star {
        display: none;
        /* Hide the checkbox */
    }

    .star-label {
        font-size: 24px;
        color: #ddd;
        /* Default color for an unchecked star */
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }

    /* Change the color when the checkbox is checked */
    .favorite-star:checked+.star-label {
        color: #ffcc00;
        /* Star color when "checked" */
    }
</style>