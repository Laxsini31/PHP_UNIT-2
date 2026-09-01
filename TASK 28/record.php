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


$recordDirectory =
    "medical_records";


$records = [];


/*
 * Read medical records
 */

if (is_dir($recordDirectory)) {

    $records =
        array_diff(
            scandir($recordDirectory),
            [".", ".."]
        );

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Medical Records</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <h1>Available Medical Records</h1>


<?php

if (count($records) > 0) {

?>

<table>

    <tr>

        <th>Medical Record</th>

        <th>Action</th>

    </tr>


<?php

foreach (
    $records
    as $record
) {

?>

<tr>

    <td>

        <?php

        echo htmlspecialchars($record);

        ?>

    </td>


    <td>

        <form action="view_record.php"
              method="post">

            <input type="hidden"
                   name="file_name"

                   value="<?php

                   echo htmlspecialchars(
                       $record
                   );

                   ?>">


            <input type="submit"
                   value="View">

        </form>

    </td>

</tr>

<?php

}

?>

</table>

<?php

}

else {

?>

<div class="error-box">

    <p>
        No medical records are available.
    </p>

</div>

<?php

}

?>


<a href="dashboard.php"
   class="back">

    Back to Dashboard

</a>

</div>

</body>

</html>