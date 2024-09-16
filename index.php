<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/16 15:55:50
include "./components/header.php"
?>
<script src="./functions/checkURLOnline.js"></script>


<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="dash-main bg-dark">
                <div class="cards-container">
                    <div id="websiteStatus">
                        <details id="demo-accordion-vt">
                            <summary class="component-header">Website Status Indicators</summary>
                            <!-- <h4 class="component-header">Website Status Indicators</h4> -->
                            <div id="urlStatus" class="details-content"></div>
                        </details>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <?php include "./components/footer.php" ?>
</body>

</html>
<script>
    makeWebsiteStatusCards()
</script>
<script>
    const details = document.querySelector('#demo-accordion-vt');
    const content = details.querySelector('#demo-accordion-vt .details-content');
    const summary = details.querySelector('#demo-accordion-vt summary');

    summary.addEventListener('click', async (e) => {
        e.preventDefault();
        let transition = document.startViewTransition(() => {
            if (details.open) {
                details.open = false;
            } else {
                details.open = true;
            }
        });
    });
</script>

<style>
    .dash-main {
        padding: 1rem !important;
        height: 100%;
        display: flex;
    }

    .websiteStatus {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .cards-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 20px;
        min-height: fit-content;
        /* margin-left: auto; */
        /* margin-right: auto; */
        /* background-color: light-dark(#5b89a1, #1b283c); */
    }

    .card-title a {
        font-size: large !important;
    }

    ::marker,
    ::-webkit-details-marker {
        display: none;
    }

    summary {
        list-style: none;
    }

    details summary:before {
        content: '→';
        display: inline-block;
        rotate: 0deg;
        margin-inline-end: 0.5em;
        transition: rotate 0.3s ease-in-out;
    }

    details[open]>summary:before {
        rotate: 90deg;
    }
</style>