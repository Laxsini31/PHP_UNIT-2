<?php

session_start();


/*
 * Check login
 */

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    &&
    isset($_POST["login"])
) {

    $username =
        trim($_POST["username"]);

    $password =
        trim($_POST["password"]);


    /*
     * Sample authentication
     */

    if (
        $username == "doctor"
        &&
        $password == "medical123"
    ) {

        /*
         * Create secure session
         */

        session_regenerate_id(true);


        $_SESSION["medical_user"] =
            $username;


        $_SESSION["authenticated"] =
            true;


        /*
         * Redirect to dashboard
         */

        header(
            "Location: dashboard.php"
        );

        exit;

    }

    else {

        $message =
            "Invalid username or password.";

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

    <h1>Login Result</h1>


<div class="error-box">

    <h2>Access Denied!</h2>

    <p>

        <?php

        echo htmlspecialchars(
            $message
        );

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