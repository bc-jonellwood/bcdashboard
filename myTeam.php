<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/25 10:54:15
include "./components/header.php"
?>

<script>
    function getRandomColorName() {
        const colorNames = ["Red", "DeepPink", "Yellow", "Green", "Blue", "Purple", "Coral", "DarkGoldenRod", "Darkorange"];
        return colorNames[Math.floor(Math.random() * colorNames.length)];
    }

    function getInitials(name) {
        return name
            .split(" ")
            .slice(0, 2) // Take only the first two name parts
            .map((n) => n[0])
            .join("")
            .toUpperCase();
    }
    async function getTeamMembers() {
        await fetch('./API/getTeam.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                let html = "";
                for (var i = 0; i < data.length; i++) {
                    let favColor = getRandomColorName();
                    let initials = getInitials(data[i].empName);
                    html += `
                        <div class="emp-card">
                        <div class="emp-avatar">
                                <p style="background-color: ${favColor};">${initials}</p>
                            </div>
                            <h3>${data[i].empName}</h3>
                            <a href="mailto:${data[i].email}">
                                ${data[i].email}
                            </a>
                             <div class="fav-color">
                                <p><b>Favorite Color: </b> </p>
                                <p style="color: ${favColor};"> ${favColor}</p>
                            </div>
                            
                        </div>
                    `
                }
                document.getElementById("team-card-holder").innerHTML = html;
            })
    }
    getTeamMembers();
</script>
<!-- <script src="./functions/getInitials.js"></script> -->

<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="team-main">
                <div id="team-card-holder"></div>
            </div>

        </div>
        <div class="list">LIST</div>
    </div>
    </div>

    <?php include "./components/footer.php" ?>
</body>

</html>


<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        display: grid;
        grid-template-columns: 5fr 1fr;
    }

    .team-main {
        padding: 1rem !important;
        height: 100%;
        display: grid;
        /* background-color: #000; */
        /* overflow: scroll; */
    }

    .headline {
        padding: 20px;
        margin-left: -20px;
        margin-top: -20px;
    }

    #team-card-holder {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 15px;
        min-height: fit-content;

    }

    .emp-card {
        width: -webkit-fill-available;
        padding: 20px;
        /* background-color: #99bbc9; */
        background-color: var(--bg);
        border: 2px solid;
        border-color: light-dark(#111, #ddd);
        border-radius: 7px;
        box-shadow: 0 0 5px 0px #808080;
        color: light-dark(#000, #ddd);
        filter: brightness(1.5);

        a,
        p {
            font-size: medium;
        }
    }

    .emp-card:hover {
        border-color: var(--bg);
        /* border-image-source: linear-gradient(to left, #03A9F4, #05DB6C); */
        filter: brightness(1.6);
    }

    .fav-color {
        display: flex;
        flex-direction: row;
        width: 100%;
        gap: 5px;
    }

    a {
        color: inherit !important;
        text-decoration: none !important;

    }

    .emp-avatar {
        margin-left: -60px;
        margin-top: -60px;
        color: var(--fg);

        p {
            border-radius: 100%;
            font-weight: 700;
            font-size: 2rem;
            line-height: 2.5rem;
            text-align: center;
            padding: 2rem;
            width: 2.5rem;
            height: 2.5rem;
            margin: 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            border-color: dark-light(var(--fg), var(--bg));
            filter: invert(1)
        }
    }

    /* .emp-avatar-img {
        margin-left: -33px;
        margin-bottom: -33px;
        
        aspect-ratio: 1 / 1;
        height: 75px;
    } */
</style>

<!-- indigo: {
100: "#ccdde4",
200: "#99bbc9",
300: "#669aad",
400: "#337892",
500: "#005677",
600: "#00455f",
700: "#003447",
800: "#002230",
900: "#001118"
}, -->