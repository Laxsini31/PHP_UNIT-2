<?php

session_start();

$userName = "";


/*
 * Get remembered user name
 */

if (isset($_COOKIE["user_name"])) {

    $userName =
        $_COOKIE["user_name"];

}


/*
 * Get logged-in user
 */

if (isset($_SESSION["user_name"])) {

    $userName =
        $_SESSION["user_name"];

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>User Activity and File Access Log System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>User Activity and File Access Log System</h1>

    <p>
        Login and track your file access activities.
    </p>


<?php

if (!isset($_SESSION["user_name"])) {

?>

    <h2>User Login</h2>

    <form action="process.php"
          method="post">

        <label>User Name</label>

        <input type="text"
               name="user_name"
               placeholder="Enter your name"
               required>


        <input type="submit"
               name="login"
               value="Login">

    </form>

<?php

}

else {

?>

    <div class="welcome-box">

        <h2>Welcome!</h2>

        <p>

            <?php

            echo htmlspecialchars(
                $userName
            );

            ?>

        </p>

    </div>


    <h2>Access a File</h2>

    <form action="process.php"
          method="post">

        <label>Select File</label>

        <select name="file_name"
                required>

            <option value="">
                Select File
            </option>

            <option value="student_report.txt">
                Student Report
            </option>

            <option value="attendance_report.txt">
                Attendance Report
            </option>

            <option value="marks_report.txt">
                Marks Report
            </option>

        </select>


        <input type="submit"
               name="access_file"
               value="Access File">

    </form>


    <h2>User Activity Report</h2>

    <form action="process.php"
          method="post">

        <input type="submit"
               name="view_report"
               value="View Activity Report">

    </form>


    <a href="process.php?action=logout"
       class="logout">

        Logout

    </a>

<?php

}

?>

</div>

</body>

</html>