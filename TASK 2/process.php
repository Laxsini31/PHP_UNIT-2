<?php

// File name

$fileName = "article.txt";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Article Display</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Article Details</h1>

<?php

try {

    // Check whether the file exists

    if (!file_exists($fileName)) {

        throw new Exception(
            "Article file not found."
        );

    }


    // Read all lines from the file

    $lines = file($fileName);


    // Count the number of lines

    $lineCount = count($lines);


    // Read complete file content

    $content = file_get_contents($fileName);

?>

<div class="success-box">

    <h2 class="success">
        Article Read Successfully!
    </h2>

    <table>

        <tr>
            <th>Details</th>
            <th>Information</th>
        </tr>

        <tr>
            <td>File Name</td>
            <td>
                <?php
                echo htmlspecialchars($fileName);
                ?>
            </td>
        </tr>

        <tr>
            <td>Total Number of Lines</td>
            <td>
                <?php echo $lineCount; ?>
            </td>
        </tr>

    </table>


    <h2>Article Content</h2>

    <div class="article">

        <?php

        echo nl2br(
            htmlspecialchars($content)
        );

        ?>

    </div>

</div>

<?php

}

catch (Exception $e) {

?>

<div class="error-box">

    <h2 class="error">
        File Reading Error!
    </h2>

    <p>
        <?php
        echo htmlspecialchars(
            $e->getMessage()
        );
        ?>
    </p>

</div>

<?php

}

?>

<br>

<a href="index.html" class="back">
    Read Another Article
</a>

</div>

</body>
</html>