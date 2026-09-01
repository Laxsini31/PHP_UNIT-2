<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Secure Medical Record Management System</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Secure Medical Record Management System</h1>

    <p>
        Login to securely access medical records.
    </p>


    <h2>User Login</h2>

    <form action="process.php"
          method="post">

        <label>Username</label>

        <input type="text"
               name="username"
               placeholder="Enter username"
               required>


        <label>Password</label>

        <input type="password"
               name="password"
               placeholder="Enter password"
               required>


        <input type="submit"
               name="login"
               value="Login">

    </form>

</div>

</body>

</html>