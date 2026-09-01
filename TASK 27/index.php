<?php

session_start();


/*
 * Check remembered username
 */

$rememberedUser = "";

if (
    isset($_COOKIE["exam_user"])
) {

    $rememberedUser =
        $_COOKIE["exam_user"];

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Secure Examination Access Control System</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Secure Examination Access Control System</h1>

    <p>
        Login to access the online examination system.
    </p>


    <h2>Student Login</h2>

    <form action="process.php"
          method="post">

        <label>Username</label>

        <input type="text"
               name="username"
               placeholder="Enter username"

               value="<?php

               echo htmlspecialchars(
                   $rememberedUser
               );

               ?>"

               required>


        <label>Password</label>

        <input type="password"
               name="password"
               placeholder="Enter password"
               required>


        <label class="remember">

            <input type="checkbox"
                   name="remember">

            Remember Me

        </label>


        <input type="submit"
               name="login"
               value="Login and Access Examination">

    </form>

</div>

</body>

</html>