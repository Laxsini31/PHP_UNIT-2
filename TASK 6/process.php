<?php

$message = "";
$lastLogin = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userName = trim($_POST["user_name"]);


    // Set the timezone

    date_default_timezone_set(
        "Asia/Kolkata"
    );


    // Check whether username is empty

    if (empty($userName)) {

        $message =
            "Please enter your name.";

    }

    else {

        /*
         * Check whether the last login cookie exists
         */

        if (isset($_COOKIE["last_login"])) {

            $lastLogin =
                $_COOKIE["last_login"];

        }


        /*
         * Get the current login date and time
         */

        $currentLogin =
            date(
                "d-m-Y h:i:s A"
            );


        /*
         * Store current login time in cookie
         */

        setcookie(
            "last_login",
            $currentLogin,
            time() + (30 * 24 * 60 * 60),
            "/"
        );


        /*
         * Store username in cookie
         */

        setcookie(
            "user_name",
            $userName,
            time() + (30 * 24 * 60 * 60),
            "/"
        );

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Login Result</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Login Information</h1>

<?php

if (!empty($message)) {

?>

<div class="error-box">

    <h2 class="error">
        Error!
    </h2>

    <p>

        <?php
        echo htmlspecialchars($message);
        ?>

    </p>

</div>

<?php

}

else {

?>

<div class="success-box">

    <h2 class="success">
        Login Successful!
    </h2>


    <p>

        Welcome,

        <strong>

            <?php
            echo htmlspecialchars($userName);
            ?>

        </strong>

    </p>


<?php

if (!empty($lastLogin)) {

?>

    <div class="login-details">

        <h2>
            Your Last Login
        </h2>

        <p>

            <?php
            echo htmlspecialchars(
                $lastLogin
            );
            ?>

        </p>

    </div>

<?php

}

else {

?>

    <div class="login-details">

        <h2>
            Welcome!
        </h2>

        <p>
            This is your first login.
        </p>

    </div>

<?php

}

?>


    <div class="login-details">

        <h2>
            Current Login Time
        </h2>

        <p>

            <?php
            echo htmlspecialchars(
                $currentLogin
            );
            ?>

        </p>

    </div>

</div>

<?php

}

?>

<br>

<a href="index.html" class="back">
    Login Again
</a>

</div>

</body>

</html>