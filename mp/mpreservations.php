<?php
// Created: 2024/12/17 09:22:51
// Last modified: 2024/12/18 12:12:44

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../mp/mpnav.php');
?>
<div class="main">
    <div class="content">
        <div class="reservations-content" id="reservations-content"></div>
    </div>
</div>


<?php include(dirname(__FILE__) . '/../components/footer.php'); ?>


<script>
    async function getReservations() {
        await fetch('/API/mpGetReservations.php')
            .then(response => response.json())
            .then(data => {
                let reservations = data;
                let content = `<h1>Motor Pool Reservations</h1>
                <table class="table table-sm table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Vehicle Name</th>
                            <th>Unit Number</th>
                            <th>Pickup</th>
                            <th>Drop Off</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;
                reservations.forEach(reservation => {
                    content += `<tr>
                        <td>${reservation.sEmpName.toLowerCase()}</td>
                        <td>${reservation.sVehName}</td>
                        <td>${reservation.sVehUnitNum}</td>
                        <td>${formatDateAndTime(reservation.dtStart)}</td>
                        <td>${formatDateAndTime(reservation.dtEnd)}</td>
                        <td>${reservation.sNotes}</td>
                        <td>
                            <button class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>`;
                });
                content += `</tbody>
                </table>`;
                document.getElementById('reservations-content').innerHTML = content;
            });
    }
    getReservations();

    function formatDateAndTime(str) {
        const date = new Date(str);
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes.toString().padStart(2, '0');
        return `${month}/${day}/${year} @ ${hours}:${minutes} ${ampm}`;
    }
</script>

<style>
    .reservations-content {
        margin: 20px;
    }

    .table {
        border: none !important;
        color: var(--fg) !important;
        background-color: var(--bg) !important;
        font-size: large !important;
        text-transform: capitalize;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border: none !important;
    }

    th {
        border-top: 1px solid var(--accent) !important;
    }
</style>