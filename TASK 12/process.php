<?php

session_start();

$message = "";


/*
 * Check whether login form is submitted
 */

if (isset($_POST["login"])) {

    $userName =
        trim($_POST["user_name"]);

    $password =
        trim($_POST["password"]);


    /*
     * Demo user credentials
     */

    $validUserName = "student";

    $validPassword = "php123";


    /*
     * Validate login details
     */

    if (
        $userName == $validUserName &&
        $password == $validPassword
    ) {

        /*
         * Regenerate session ID
         * for better session security
         */

        session_regenerate_id(true);


        /*
         * Store login information
         * in session
         */

        $_SESSION["logged_in"] = true;

        $_SESSION["user_name"] =
            $userName;


        /*
         * Cookie-based authentication
         * when Remember Me is selected
         */

        if (isset($_POST["remember"])) {

            setcookie(
                "remember_user",
                $userName,
                time() + (7 * 24 * 60 * 60),
                "/",
                "",
                false,
                true
            );

        }


        $message =
            "Login successful.";

    }

    else {

        $message =
            "Invalid username or password.";

    }

}


/*
 * Check session authentication
 */

if (
    !isset($_SESSION["logged_in"]) ||
    $_SESSION["logged_in"] != true
) {

?>

<!DOCTYPE html>
<html>

<head>

    <title>Login Error</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Secure Login System</h1>

    <div class="error-box">

        <h2>Error!</h2>

        <p>

            <?php
            echo htmlspecialchars($message);
            ?>

        </p>

    </div>


    <a href="index.php"
       class="back">

        Back to Login

    </a>

</div>

</body>

</html>

<?php

    exit();

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>User Dashboard</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Welcome to User Dashboard</h1>


    <div class="success-box">

        <h2>
            Login Successful
        </h2>

        <p>

            Welcome,

            <?php
            echo htmlspecialchars(
                $_SESSION["user_name"]
            );
            ?>

        </p>

        <p>
            Your session is active.
        </p>

    </div>


    <div class="details-box">

        <h2>Authentication Details</h2>

        <p>

            <strong>
                Session Authentication:
            </strong>

            User login information is stored
            temporarily on the server.

        </p>

        <p>

            <strong>
                Cookie Authentication:
            </strong>

            The "Remember Me" option stores
            login information in a browser cookie.

        </p>


<?php

if (isset($_COOKIE["remember_user"])) {

?>

        <p>

            <strong>
                Remember Me:
            </strong>

            Enabled

        </p>

<?php

}

else {

?>

        <p>

            <strong>
                Remember Me:
            </strong>

            Not Enabled

        </p>

<?php

}

?>

    </div>


    <a href="logout.php"
       class="logout">

        Logout

    </a>

</div>

</body>

</html>