<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Online Shopping User Management</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Online Shopping User Management</h1>

    <p>
        Login to manage your shopping cart
        and browsing history.
    </p>

    <form action="process.php"
          method="post">

        <input type="hidden"
               name="action"
               value="login">

        <label>User Name</label>

        <input type="text"
               name="user_name"
               placeholder="Enter your name"
               required>

        <input type="submit"
               value="Login">

    </form>

</div>

</body>

</html>