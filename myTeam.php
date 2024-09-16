<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/13 09:56:38
include "./components/header.php"
?>

<script>
    async function getTeamMembers() {
        await fetch('./API/getTeam.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                let html = "";
                for (var i = 0; i < data.length; i++) {
                    html += `
                        <div class="emp-card">
                            <h3>${data[i].empName}</h3>
                            <a href="mailto:${data[i].email}">
                                ${data[i].email}
                            </a>
                             <p class = "fav-color" > Favorite Color: ${getRandomColorName()}</p>
                        </div>
                    `
                }
                document.getElementById("team-card-holder").innerHTML = html;
            })
    }
    getTeamMembers();
</script>

<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="content">
            <div class="team-main bg-dark">
                <!-- <div class="bg-dark">
                    <h1 class="headline">My Team</h1>
                </div> -->
                <div id="team-card-holder" class="bg-dark"></div>
            </div>

        </div>
    </div>
    </div>

    <?php include "./components/footer.php" ?>
</body>

</html>


<script>
    function getRandomColorName() {
        const colorNames = ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Pink", "Brown", "Gray", "Black", "White"];
        return colorNames[Math.floor(Math.random() * colorNames.length)];
    }
</script>

<style>
    .main {
        overflow: auto;
    }

    .team-main {
        padding: 1rem !important;
        height: 100%;
        display: grid;
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
        gap: 10px;
        min-height: fit-content;

    }

    .emp-card {
        width: 300px;
        padding: 20px;
        background-color: #99bbc9;
        border: 2px solid #005677;
        border-radius: 7px;
        box-shadow: 0 0 5px 0px #808080;
        color: #000;

        a,
        p {
            font-size: medium;
        }
    }

    .emp-card:hover {
        border-color: #669aad;
    }

    a {
        color: inherit !important;
        text-decoration: none !important;

    }
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