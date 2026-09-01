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


$user =
    $_SESSION["medical_user"];

?>

<!DOCTYPE html>
<html>

<head>

    <title>Medical Record Dashboard</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Medical Record Dashboard</h1>


<div class="success-box">

    <h2>Access Granted!</h2>

    <p>

        Welcome,

        <?php

        echo htmlspecialchars($user);

        ?>

    </p>

</div>


<h2>Upload Medical Record</h2>

<form action="upload.php"
      method="post"
      enctype="multipart/form-data">

    <label>Select Medical Report</label>

    <input type="file"
           name="medical_file"
           required>


    <p class="note">

        Allowed formats: PDF and TXT<br>

        Maximum file size: 2 MB

    </p>


    <input type="submit"
           name="upload"
           value="Upload Medical Record">

</form>


<h2>Available Medical Records</h2>

<form action="records.php"
      method="post">

    <input type="submit"
           value="View Medical Records">

</form>


<a href="logout.php"
   class="logout">

    Logout

</a>

</div>

</body>

</html>