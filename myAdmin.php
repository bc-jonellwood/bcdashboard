<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/14 09:07:30

include "./components/header.php" ?>

<div class="main">
    <?php include "./components/sidenav.php" ?>

    <div class="content">
        <div class="form-holder">
            <form action="./API/addUser.php" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text">Username</span>
                    <input type="text" class="form-control" aria-label="Username" name="sUserName">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Password</span>
                    <input type="password" aria-label="Password" name="sPassword" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">First and last name</span>
                    <input type="text" aria-label="First name" name="sFirstName" class="form-control">
                    <input type="text" aria-label="Last name" name="sLastName" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Email Address</span>
                    <input type="email" aria-label="Email Address" name="sEmail" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">Phone and Label</span>
                    <input type="tel" aria-label="Phone" name="sMainPhoneNumber" class="form-control">
                    <input type="text" aria-label="Main Phone Number Label" name="sMainPhoneNumberLabel" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Department Number</span>
                    <input type="number" aria-label="Department Number" name="iDepartmentNumber" class="form-control">
                </div>

                <div class="input-group mb-3">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "./components/footer.php" ?>

<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        display: grid;
        /* grid-template-columns: 5fr 1fr; */
        grid-template-columns: 3fr 3fr;
    }

    .form-holder {
        margin: 20px;
        padding: 10px;
    }
</style>