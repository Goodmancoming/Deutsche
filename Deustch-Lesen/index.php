<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junction</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <p>
        <h1>
            Available Pages
        </h1>
    </p>
<?php

$filesphp  = glob("*.php");
echo "<ul>";
echo "<br><h2>php files here</h2>";
foreach ($filesphp as $filephp) {
    echo "<li><a href='$filephp'>$filephp</a></li>";
};

echo "</ul><br><br><br>";
?>
<div class="container">
<hr>
<br>
<a href="../all%20codes%20og/1%20junction.php">[:Archive Junction:]</a>
<br>
<a href="../Testing%20Grounds/Facility%20gate.php">[:Facility Gate:]</a>
<br>
<a href="../The-Ansamble/ravalino_DPK_T13.php">[:The Wiki:]</a>
<br>
<br>
<hr>
</div>
    
</body>
</html>