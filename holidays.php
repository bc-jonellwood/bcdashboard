<?php
// Created: 2024/12/10 11:37:28
// Last modified: 2024/12/20 09:02:56

include "./components/header.php";
?>
<script>
    async function renderHolidaysAsCalendar() {
        await fetch('./API/getHolidays.php')
            .then((response) => response.json())
            .then((data) => {
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                // console.log(data);
                const holidayContent = document.getElementById('holiday-content');
                holidayContent.innerHTML = '';

                const calendar = document.createElement('div');
                calendar.className = 'calendar';

                data.forEach(holiday => {
                    const holidayDiv = document.createElement('div');
                    holidayDiv.className = 'holiday';

                    const holidayName = document.createElement('h2');
                    holidayName.textContent = holiday.sName;

                    const holidayDate = document.createElement('p');
                    holidayDate.textContent = new Date(holiday.dtDate + 'T00:00:00').toLocaleDateString('en-US', options);


                    holidayDiv.appendChild(holidayName);
                    holidayDiv.appendChild(holidayDate);
                    calendar.appendChild(holidayDiv);
                });

                holidayContent.appendChild(calendar);
            });
    }
    renderHolidaysAsCalendar();

    // Insert current year into the h1 tag
    // document.addEventListener('DOMContentLoaded', () => {
    //     const currentYear = new Date().getFullYear();
    //     document.querySelector('.main h1').textContent += currentYear;
    // });
</script>


<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <h1>Holidays for </h1>
        <div id="holiday-content">
            <!-- Holidays will be rendered here -->
        </div>
    </div>

    <?php include './components/footer.php'; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const currentYear = new Date().getFullYear();
        document.querySelector('.main h1').textContent += currentYear;
    });
</script>

<style>
    h1 {
        text-align: center;
        font-size: 2rem;
        margin-top: 20px;
    }

    img {
        height: 75dvh;
        width: auto;
        /* width: 100%; */
        /* height: auto; */
        margin-left: auto;
        margin-right: auto;
    }

    .calendar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
        width: 75dvh;
        margin: auto;
        background-color: var(--bg);
    }

    .holiday {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        width: 150px;
        text-align: center;
        /* background-color: #f9f9f9; */
        color: var(--fg);

        p {
            font-size: 1rem;
            position: relative;
            bottom: 0;
            margin: 0 !important;
        }
    }

    .holiday p {
        margin-top: auto;
    }

    .holiday h2 {
        font-size: 1.2rem;
        margin: 0;
    }

    /* .holiday p {
        margin: 5px 0 0;
    } */
</style>