<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/04 13:44:37

include "./components/header.php"
?>
<script src="./functions/renderContactList.js"></script>
<script>
    function fakeLoader() {
        showLoader();
        setTimeout(hideLoader, 500);
    }
    // fakeLoader()

    function getOtherNumbers() {
        showLoader();
        fetch("./API/getOtherPhoneNumbers.php")
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                hideLoader();
                renderContactList(data);
                // renderOtherNumbers(data);
            })
    }
    getOtherNumbers();
</script>

<div class="main">
    <?php include "./components/sidenav.php" ?>

    <div class="contact-list" id="contact-list">
        <p>List</p>
    </div>
    <div class="contact-details" id="contact-details">
        <p></p>
    </div>

</div>
<?php include "./components/footer.php" ?>

<style>
    .main {
        border: 1px solid hotpink;
        grid-template-columns: 1fr 2fr;
    }

    .contact-list {
        margin: 20px;
        padding: 10px;
        height: 100vh;
        background-color: var(--accent);
        overflow: hidden;
        scrollbar-gutter: stable both-edges;


        .list-group-item {
            background-color: transparent;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: var(--bg);
            border-radius: 7px;

            li {
                border-bottom: 1px dashed var(--accent);
                display: flex;
                align-items: center;
            }

            li:hover {
                filter: brightness(1.25);
            }

            li p {
                color: var(--fg);
                padding: 10px;
                margin-bottom: 10px;
                border-radius: 5px;
            }


        }
    }

    .contact-list:hover {
        overflow-y: scroll;
    }

    .contact-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 10% 25% 25% 25%;
        gap: 20px;
        margin: 20px;
        height: 100vh;
        overflow: hidden;
        margin-left: auto;
        margin-right: auto;
        scrollbar-gutter: stable both-edges;

        .contact-card {
            width: 400px;
            height: 200px;
            border: 1px solid var(--accent);

            background-color: var(--bg);
            color: var(--fg);
            border-radius: 5px;
            padding: 2rem;
            margin: 1rem;
            filter: drop-shadow(0 0 0.35rem var(--accent));
        }

        .contact-card-contact-name {
            font-size: x-large;
            margin-bottom: 25px;
            border-bottom: 1px dashed var(--accent);
            min-height: 3.5em;
            font-weight: bold;
        }
    }

    .org-name {
        display: flex;
        flex-wrap: wrap;
        grid-column-start: 1;
        grid-column-end: 3;
        text-align: center;
        font-size: xx-large !important;
        /* font-family: pixelify !important; */
        border: 1px solid var(--accent);
        background-color: var(--bg);
        color: var(--fg);
        border-radius: 5px;
        padding: 1rem;
        margin: 1rem;
        filter: drop-shadow(0 0 0.35rem var(--accent));
        max-height: 5rem;
        align-content: center;
        justify-content: center;
    }

    .contact-details:hover {
        overflow-y: scroll;
    }

    .first-initial {
        font-size: xx-large !important;
        /* font-family: pixelify !important; */
        border: 1px solid var(--accent);
        background-color: var(--bg);
        color: var(--fg);
        border-radius: 50% !important;
        padding: 1rem;
        margin: 1rem;
        filter: drop-shadow(0 0 0.35rem var(--accent));
        width: 60px;
        height: 60px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
    }

    .contact-card-details {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-content: center;
        margin-bottom: 1em;
    }

    .type-icon {
        margin-right: 10px;
        /* background-color: var(--accent); */
        border-radius: 50%;
        height: 36px;
        width: 35px;
        filter: drop-shadow(0 0 0.15rem var(--accent));
    }
</style>