<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/25 14:30:28
include "./components/header.php"
?>
<script src="./functions/toast.js"></script>
<script>
    let emailElement;
    let isEmailTruncated = false;
    let truncatedEmail = '';

    function copyEmail(email) {
        navigator.clipboard.writeText(email);
        // alert("Email copied to clipboard");
        toast('Success', 'Email copied to clipboard', 'success');
        // toast.success('Email copied to clipboard');
        setTimeout(closeToast, 2500);
    }

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

    function truncateEmail(email) {
        const [username] = email.split('@');
        return `${username}@berkeley...`;
    }

    function checkEmailOverflow(email) {
        if (emailElement) {
            isEmailTruncated = emailElement.scrollWidth > emailElement.clientWidth;
            truncatedEmail = isEmailTruncated ? truncateEmail(email) : email;
        }
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
                    let email = data[i].email;
                    let truncatedEmail;
                    if (email) {
                        truncatedEmail = truncateEmail(data[i].email);
                        // truncatedEmail = email;
                        setTimeout(checkEmailOverflow(email), 0);
                    }
                    html += `
                        <div class="emp-card" data-emp-id="${data[i].empNumber}" id="${data[i].empName}">
                        <div class="emp-avatar">
                                <p style="background-color: ${favColor};">${initials}</p>
                            </div>
                            <h3>${data[i].empName}</h3>
                            <a href="mailto:${data[i].email}">
                                ${truncatedEmail}
                            </a>
                            <button type="button" onclick="copyEmail('${email}')" popovertarget="toast-popover" popovertargetaction="show" class="not-btn">
                            <img src="./icons/content-copy.svg" alt="Copy Email" style="width: 1rem; height: 1rem;">
                            </button>
                        </div>
                    `
                }
                let teamHtml = `
                
                        ${data.map(emp => `<tr><td class="name"><a href="#${emp.empName}">${emp.empName.toLowerCase()}</a></td> </tr>`).join('')}
                
                `
                document.getElementById("team-card-holder").innerHTML = html;
                document.getElementById("team-list-body").innerHTML = teamHtml;
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
        <div class="list" id="team-list">
            <table class="team-list-table">
                <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody id="team-list-body"></tbody>
            </table>
        </div>
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
        /* filter: brightness(1.5); */

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

    .team-list:hover {
        overflow-y: auto;
    }

    .team-list-table {
        overflow-y: auto;
        overflow-x: auto
    }

    .name {
        font-size: 1rem;
    }

    .team-list-table tr td {
        padding-top: 10px;
        padding-left: 10px;
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