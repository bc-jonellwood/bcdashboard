<?php
// Created: 2024/09/16 13:02:27
// Last modified: 2024/09/16 14:06:01
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sign In </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/custom.css">
    <link rel="stylesheet" href="styles/theme.css">

</head>

<body>
    <div class="login-container">
        <div class="login-main">
            <div class="login-header">
                <h1>Sign In</h1>
            </div>
            <form>
                <div class="form-group">
                    <!-- <label for="username">Username</label> -->
                    <input type="text" class="form-control" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <!-- <label for="password">Password</label> -->
                    <input type="password" class="form-control" id="password" placeholder="Password">
                </div>
            </form>
            <!-- <button type="submit" class="btn btn-primary">Sign In</button> -->
            <a href="index.php" class="btn btn-primary">Sign In</a>
            <p class="login-form-footer">Don't have an account? <a href="mailto:dashboard@berkeleycountysc.gov">Request One</a></p>
        </div>
    </div>


</body>
<footer class="login-footer">
    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
        <path fill="#E3E3E3" d="M10 .4A9.6 9.6 0 0 0 .4 10a9.6 9.6 0 1 0 19.2-.001C19.6 4.698 15.301.4 10 .4m-.151 15.199h-.051c-.782-.023-1.334-.6-1.311-1.371c.022-.758.587-1.309 1.343-1.309l.046.002c.804.023 1.35.594 1.327 1.387c-.023.76-.578 1.291-1.354 1.291m3.291-6.531c-.184.26-.588.586-1.098.983l-.562.387q-.46.358-.563.688c-.056.174-.082.221-.087.576v.09H8.685l.006-.182c.027-.744.045-1.184.354-1.547c.485-.568 1.555-1.258 1.6-1.287a1.7 1.7 0 0 0 .379-.387c.225-.311.324-.555.324-.793c0-.334-.098-.643-.293-.916c-.188-.266-.545-.398-1.061-.398c-.512 0-.863.162-1.072.496c-.216.341-.325.7-.325 1.067v.092H6.386l.004-.096c.057-1.353.541-2.328 1.435-2.897c.563-.361 1.264-.544 2.081-.544c1.068 0 1.972.26 2.682.772c.721.519 1.086 1.297 1.086 2.311c-.001.567-.18 1.1-.534 1.585" class="contrast" />
    </svg>
    <div id='add-year'>Copyright &copy; Berkeley County Government </div>
    <div>App Version: 0.0.0</div>
    <!-- <a href='/changelogView.php' target='_blank'>App Version: -->
    <!-- <//?php echo $_SESSION['appVersion'] ?></a> -->


</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>

</html>

<style>
    @font-face {
        font-family: "Source Sans 3";
        src: url("../fonts/Source_Sans_3/SourceSans3-VariableFont_wght.ttf") format("truetype");
        font-weight: 400 700;
        font-display: swap;
        font-style: normal;
    }

    body {
        font-family: "Source Sans 3", sans-serif;
        background-color: var(--blue);
        color: #dee0e3;
        margin: 0;
        background-image: url("images/dash_login_2.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        min-height: 100dvh;
    }

    .login-container {
        margin-left: 30%;
        margin-right: 30%;
        margin-top: 5%;
        margin-bottom: 10%;
        max-height: 100dvh;

    }

    .login-main {
        display: flex;
        flex-direction: column;
        justify-content: center;
        max-width: 30dvw;
        margin-left: auto;
        margin-right: auto;
        padding: 20px;
        /* background-color: #1b3b6f; */
        background-color: #1c293e;
        border: 2px solid #005677;
        border-radius: 7px;
        box-shadow: 0 0 5px 0px #808080;
        color: #000;
        border-radius: 7px;
    }


    .login-header {
        display: flex;
        /* background-color: #30a9de; */
        /* background-color: #7074a5; */
        background-color: #0088e2;
        height: 20dvh;
        justify-content: space-between;
        align-items: center;
        color: #ddd0e3;
        font-weight: bold;
        padding: 40px;
        padding-left: 20%;
        padding-right: 20%;
        width: 100%;
        border-radius: 7px;
        margin-top: -50px;
        margin-bottom: 60px;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.3), 0 0 10px rgba(100, 180, 255, 0.2);
        /* box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2); */
        /* box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1); */

        h1 {
            font-size: 2.5rem;
            text-align: center;
            width: 100%;

        }
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 30px;

        input {
            color: #ddd;
            font-weight: bold;
            width: 100%;
            background-color: inherit !important;
        }

    }


    button {
        margin-top: 20px !important;
        margin-bottom: 20px !important;

    }

    .login-form-footer {
        text-align: center;
        font-size: medium;
        padding: 10px;
        margin-top: 20px;
        color: #ddd;

        a {
            color: #0088e2;
        }
    }



    .login-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #ddd0e3;
        font-weight: bold;
        margin-left: auto;
        margin-right: auto;
        /* background-color: #0088e2; */
        background-color: #00000090;
        width: 76%;
        padding: 10px;
        padding-left: 40px;
        padding-right: 40px;
        border-radius: 7px;
        font-size: large;
    }
</style>