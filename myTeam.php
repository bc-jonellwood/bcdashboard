<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/09 10:17:24
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
        const colorNames = ["#fff8ac", "#fff590", "#fff374", "#ccc35d"];
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

    function makeEmail(name) {
        name = name.trim();
        console.log(name);
        return `${name}@berkeleycountsc.gov`;
    }

    function checkEmailOverflow(email) {
        if (emailElement) {
            isEmailTruncated = emailElement.scrollWidth > emailElement.clientWidth;
            truncatedEmail = isEmailTruncated ? truncateEmail(email) : email;
        }
    }

    function selectName(event, name) {
        console.log(event.target);
        var selectedNameElements = document.getElementsByClassName('border-accent');
        var selectedButtonElements = document.getElementsByClassName('selected-name');
        var buttonElement = event.target;
        console.log(selectedNameElements);
        for (let i = 0; i < selectedNameElements.length; i++) {
            selectedNameElements[i].classList.remove('border-accent');
        }
        for (let i = 0; i < selectedButtonElements.length; i++) {
            selectedButtonElements[i].classList.remove('selected-name');
        }
        selectedName = name;
        const element = document.getElementById(name);
        element.scrollIntoView({
            behavior: 'smooth'
        });
        setTimeout(() => {
            window.scrollBy(0, -70);
        }, 500);
        element.classList.add('border-accent');
        buttonElement.classList.add('selected-name');
    }

    function getRandomPhoneNumber() {
        const areaCode = Math.floor(Math.random() * 900) + 100; // 100-999
        const prefix = Math.floor(Math.random() * 900) + 100; // 100-999
        const lineNumber = Math.floor(Math.random() * 10000); // 0-9999

        return `(${areaCode}) ${prefix}-${lineNumber.toString().padStart(4, '0')}`;
    }

    async function getTeamMembers() {
        await fetch('./API/getTeam.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                let html = "";
                for (var i = 0; i < data.length; i++) {
                    let favColor = getRandomColorName();
                    let initials = getInitials(data[i].sEmployeeName);
                    // let email = data[i].sEmail ? data[i].sEmail : 'email@example.com';
                    let email = data[i].sEmail && data[i].sEmail.trim() !== '' ? data[i].sEmail : `${data[i].sFirstName}.${data[i].sLastName}`
                    let truncatedEmail;
                    if (email) {
                        truncatedEmail = truncateEmail(data[i].sEmail ? data[i].sEmail : `${data[i].sFirstName}.${data[i].sLastName}`);
                        // truncatedEmail = email;
                        setTimeout(checkEmailOverflow(email), 0);
                    }
                    html += `
                        <div class="emp-card" data-emp-id="${data[i].iEmployeeNumber}" id="${data[i].sEmployeeName}">
                        <div class="emp-avatar">
                                <p class="emp-initials" style="background-color: ${favColor};">${initials}</p>
                            </div>
                            <h3 class="emp-name-headline">${data[i].sEmployeeName.toLowerCase()}</h3>
                            <a href="mailto:${data[i].sEmail}">
                                ${truncatedEmail.toLowerCase()}
                            </a>
                            <button type="button" onclick="copyEmail('${makeEmail(email)}')" popovertarget="toast-popover" popovertargetaction="show" class="not-btn">
                            <img src="./icons/content-copy.svg" alt="Copy Email" style="width: 1rem; height: 1rem;">
                            </button>
                            <p class="phoneNumber"><img src="./icons/phone.svg" alt="Phone" style="width: 1rem; height: 1rem;"> ${data[i].SMainPhoneNumber ? data[i].SMainPhoneNumber : getRandomPhoneNumber()}</p>
                        </div>
                    `
                }
                let teamHtml = `

                        ${data.map(emp => `<tr><td class="name"><button class="not-btn" onclick="selectName(event,'${emp.sEmployeeName}')">${emp.sEmployeeName.toLowerCase()}</a></td> </tr>`).join('')}

                `
                document.getElementById("team-card-holder").innerHTML = html;
                // console.log(teamHtml);
                document.getElementById("team-list-body").innerHTML = teamHtml;
            })
    }
    getTeamMembers();
</script>
<!-- <script src="./functions/getInitials.js"></script> -->

<body class="mode-dark theme-base">
    <div class="main">
        <?php include "./components/sidenav.php" ?>
        <div class="list" id="team-list">
            <table class="team-list-table">
                <tbody id="team-list-body"></tbody>
            </table>
        </div>
        <div class="content">
            <div class="team-main">
                <div id="team-card-holder"></div>
            </div>

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
        /* grid-template-columns: 5fr 1fr; */
        grid-template-columns: 1fr 5fr;
    }

    .team-main {
        padding: 1rem !important;
        height: 100%;
        display: grid;
        /* background-color: var(--fg); */
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
        gap: 30px;
        min-height: fit-content;
        /* background-image:
            linear-gradient(to top right, #ffafdc 0%, 10%, #ff99d8 0% 0%, 26%, #ff7bd3 0% 0%, 46%, #ff4fcf 0% 0%, 72%, #ff00ca 0% 0%); */
    }

    .emp-card {
        width: -webkit-fill-available;
        padding: 20px;
        /* background-color: #99bbc9; */

        background-color: var(--bg);
        /* background-color: #00000080; */
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

    .emp-card:before {
        content: "";
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        filter: blur(5px);
        background-clip: padding-box;
        border-radius: 16px;
        z-index: -1;
        overflow: hidden;
    }

    .emp-card:hover {
        border-color: var(--bg);
        /* border-image-source: linear-gradient(to left, #03A9F4, #05DB6C); */
        /* filter: brightness(1.6); */
        background-color: var(--highlight);

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

        }
    }

    .emp-initials {
        color: var(--accent) !important;

    }


    .emp-name-headline {
        font-size: clamp(12px, 2vw, 22px);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-transform: capitalize;
    }

    .list {
        height: 100vh;
        /* overflow-y: auto; */
        scrollbar-gutter: stable;
    }

    .list:hover {
        overflow-y: scroll;
        /* scrollbar-gutter: stable; */
    }

    .team-list-table {
        /* overflow-y: auto; */
        /* scrollbar-gutter: stable both-edges; */
        /* overflow-x: auto */
    }

    .name,
    .name button {
        font-size: 1rem;
        text-transform: capitalize;
        color: var(--fg);
    }

    .team-list-table tr td {
        padding-top: 10px;
        padding-left: 10px;
    }

    .border-accent {
        border-color: var(--accent) !important;
        border-width: 2px;
        border-style: inset;
        /* filter: brightness(1.6); */
        box-shadow: inset 0px 0px 10px 1px var(--accent);

        background-color: var(--highlight) !important;
    }



    .selected-name {
        color: var(--accent) !important;
    }

    .phoneNumber {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
    }
</style>