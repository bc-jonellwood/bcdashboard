<?php
// Created: 2025/01/13 10:36:06
// Last modified: 2025/01/15 14:34:56

// include(dirname(__FILE__) . '/../classes/User.php');
include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/User.php');
// include(dirname(__FILE__) . '/../auth/UserAuth.php');
$user = new User();
// $auth = new UserAuth();
$pageId = '6b10ba2d-d032-49d6-86d1-c661267e4549';
$accessRequired = Page::getAccessRequired($pageId);
AccessControl::enforce($accessRequired);

?>

<link rel="stylesheet" type="text/css" href="users.css">
<div class="main">
    <h1>Only use this to add non LDAP users. This page might be a really bad idea.</h1>
    <div class="content">
        <form method="post">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required onchange="checkIfEmailExists(this.value)">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required onchange="checkIfUserNameExists(this.value)">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="passwordConfirm">Confirm Password</label>
                <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" required onchange="checkPasswordMatch()">
            </div>
            <button type="button" class="btn btn-primary" name="submit" onclick="submitFormData()">Add User</button>
            <a href="/ua/index.php" class="btn btn-warning">Cancel</a>
        </form>
        <div class="error-messages">
            <p class="error" id="firstNameErrorMessage"></p>
            <p class="error" id="lastNameErrorMessage"></p>
            <p class="error" id="emailErrorMessage"></p>
            <p class="error" id="userNameErrorMessage"></p>
            <p class="error" id="passwordErrorMessage"></p>
            <p class="success" id="passwordSuccessMessage"></p>
            <p class="error" id="passwordConfirmErrorMessage"></p>
        </div>
    </div>
</div>
<script>
    function checkIfUserNameExists($username) {
        var errorMessageHolder = document.getElementById("userNameErrorMessage");
        fetch("/API/checkUserNameExists.php?username=" + $username)
            .then(response => response.text())
            .then(data => {
                if (data == 1) {
                    errorMessageHolder.innerHTML = "Username already exists";
                } else {
                    errorMessageHolder.innerHTML = "";
                }
            })
    }

    function checkIfEmailExists($email) {
        var errorMessageHolder = document.getElementById("emailErrorMessage");
        fetch("/API/checkIfUserItemExists.php?table=app_users&field=sEmail&value=" + $email)
            .then(response => response.text())
            .then(data => {
                if (data == 1) {
                    errorMessageHolder.innerHTML = "Email already exists";
                } else {
                    errorMessageHolder.innerHTML = "";
                }
            })
    }

    function checkPasswordMatch() {
        var password = document.getElementById("password").value;
        var passwordConfirm = document.getElementById("passwordConfirm").value;
        if (password != passwordConfirm) {
            // document.getElementById("passwordErrorMessage").innerHTML = "Passwords do not match";
            document.getElementById("passwordConfirmErrorMessage").innerHTML = "Passwords do not match";
        } else {
            // document.getElementById("passwordErrorMessage").innerHTML = "";
            document.getElementById("passwordConfirmErrorMessage").innerHTML = "";
            document.getElementById("passwordSuccessMessage").innerHTML = "Passwords Match";
        }
    }

    function checkPasswordComplexity(password) {
        if (password.length === 0) {
            document.getElementById("passwordErrorMessage").innerHTML = "";
            document.getElementById("passwordSuccessMessage").innerHTML = "";
        }
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (regex.test(password)) {
            // document.getElementById("passwordErrorMessage").innerHTML = "Password is good to go";
            document.getElementById("passwordSuccessMessage").innerHTML = "Password is good to go";
            document.getElementById("passwordErrorMessage").innerHTML = "";
            // return true;
        } else {
            document.getElementById("passwordErrorMessage").innerHTML = "Password requires at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character";
            document.getElementById("passwordSuccessMessage").innerHTML = "";
            // return false;
        }
    }

    function submitFormData() {
        var firstName = document.getElementById("firstName").value;
        var lastName = document.getElementById("lastName").value;
        var email = document.getElementById("email").value;
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var lastNameFirstLetter = lastName.charAt(0);
        // var passwordConfirm = document.getElementById("passwordConfirm").value;
        var formData = {
            "sFirstName": firstName,
            "sLastName": lastName,
            "sEmail": email,
            "sUserName": username,
            "sPassword": password,
            // "passwordConfirm": passwordConfirm,
        }
        fetch("/API/addNoLDAPUser.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    window.location.href = "/ua/index.php?lastNameStartsWith=" + lastNameFirstLetter + "&enabled=0&temp=0";
                }
            })
    }
</script>

<!-- // lastNameStartsWith=A&enabled=1&temp=1 -->

<style>
    .main {
        margin: 20px;
        padding: 10px;
    }

    .content {
        display: grid;
        gap: 20px;
        grid-template-columns: 1fr 1fr;
    }

    .error {
        color: red;
        font-weight: bold;
    }

    .success {
        color: green;
        font-weight: bold;
    }

    form {
        background-color: var(--bg);
    }

    .form-group {
        margin-top: 20px;
    }

    .form-group:last-of-type {
        margin-bottom: 20px;
    }
</style>

<?php
include(dirname(__FILE__) . '/../components/footer.php');
?>