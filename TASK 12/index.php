<?php

session_start();


/*
 * If user is already logged in,
 * redirect to dashboard
 */

if (
    isset($_SESSION["logged_in"]) &&
    $_SESSION["logged_in"] == true
) {

    header("Location: process.php");

    exit();

}


/*
 * Check cookie-based authentication
 */

if (isset($_COOKIE["remember_user"])) {

    $_SESSION["logged_in"] = true;

    $_SESSION["user_name"] =
        $_COOKIE["remember_user"];

    header("Location: process.php");

    exit();

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Secure Session Management System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Secure Session Management System</h1>

    <p>
        Login using session-based and
        cookie-based authentication.
    </p>


    <form action="process.php"
          method="post">

        <label>User Name</label>

        <input type="text"
               name="user_name"
               placeholder="Enter username"
               required>


        <label>Password</label>

        <input type="password"
               name="password"
               placeholder="Enter password"
               required>


        <div class="checkbox-box">

            <input type="checkbox"
                   name="remember"
                   value="yes">

            Remember Me

        </div>


        <input type="submit"
               name="login"
               value="Login">

    </form>


    <div class="info-box">

        <h2>Demo Login</h2>

        <p>
            Username: student
        </p>

        <p>
            Password: php123
        </p>

    </div>

</div>

</body>

</html>