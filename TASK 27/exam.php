<?php

session_start();


/*
 * Prevent unauthorized access
 */

if (
    !isset($_SESSION["authenticated"])
    ||
    $_SESSION["authenticated"] !== true
) {

    header(
        "Location: index.php"
    );

    exit;

}


$username =
    $_SESSION["exam_user"];

?>

<!DOCTYPE html>
<html>

<head>

    <title>Online Examination</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Online Examination System</h1>


<div class="success-box">

    <h2>Access Granted!</h2>

    <p>

        Welcome,

        <?php

        echo htmlspecialchars(
            $username
        );

        ?>

    </p>

</div>


<div class="exam-box">

    <h2>Examination Dashboard</h2>

    <p>
        You have successfully accessed the
        secure examination system.
    </p>

    <p>
        Only authenticated users can view
        this page.
    </p>

</div>


<a href="logout.php"
   class="logout">

    Logout

</a>

</div>

</body>

</html>