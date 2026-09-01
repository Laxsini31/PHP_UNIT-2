<?php

session_start();


/*
 * Check form submission
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username =
        trim($_POST["username"]);

    $password =
        trim($_POST["password"]);


    /*
     * Check login details
     */

    if (
        $username == "admin"
        &&
        $password == "12345"
    ) {

        /*
         * Store authenticated user
         */

        $_SESSION["username"] =
            $username;


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


<?php

if (isset($message)) {

?>

<div class="error-box">

    <h2>Error!</h2>

    <p>

        <?php

        echo htmlspecialchars(
            $message
        );

        ?>

    </p>

</div>

<?php

}

?>


<a href="index.html"
   class="back">

    Back to Login

</a>

</div>

</body>

</html>