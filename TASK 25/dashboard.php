<?php

session_start();


/*
 * Check authentication
 */

if (
    !isset(
        $_SESSION["username"]
    )
) {

    /*
     * Redirect unauthorized user
     */

    header(
        "Location: index.html"
    );

    exit;

}


$username =
    $_SESSION["username"];

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

    <h1>User Dashboard</h1>


<div class="success-box">

    <h2>Login Successful!</h2>

    <p>

        Welcome,

        <?php

        echo htmlspecialchars(
            $username
        );

        ?>

    </p>

</div>


<div class="dashboard-box">

    <h2>Dashboard</h2>

    <p>
        You have successfully logged in and
        been redirected to the dashboard page.
    </p>

</div>


<a href="logout.php"
   class="logout">

    Logout

</a>

</div>

</body>

</html>