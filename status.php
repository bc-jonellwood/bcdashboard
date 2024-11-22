<?php
// Created: 2024/11/19 11:51:28
// Last modified: 2024/11/19 12:06:28

include "./components/header.php";
?>
<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <h1>This is my status page</h1>
        <p>jon.ellwood current status is: "Out of the OFfice."</p>
        <p>Last updated: 2024/11/19 13:12:49</p>
        <label for="status-select">Update Status:</label>
        <select name="status-select" id="status-select">
            <option value="0">Available</option>
            <option value="1">Not in the office</option>
            <option value="2">Personal Leave</option>
            <option value="3">Lunch</option>
            <option value="4">On the Floor Call cell</option>
            <option value="5">At another building</option>
            <option value="6">Offsite Coverage</option>
        </select>
    </div>
</div>


<?php include "./components/footer.php"; ?>