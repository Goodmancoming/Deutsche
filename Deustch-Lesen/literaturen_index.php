<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/.css">
    <title>Bibliothek</title>

</head>
<body class="pcbg">
    <div style=" margin-left:auto; margin right:auto;: width:100%; height: 100vh; justify-content: center; align-items: center;">
            <center>
                <h2 style="color:  white; font-family: 'Courier New', Courier, monospace; margin-top: 100px; font-size: 100px; font-weight:lighter;">
                    [:SOMETHING WENT WRONG:] 
                </h2>

                <hr style="width: 90%; border: white double 3px;">

                <br><br><br>

                <h2 style="color: rgba(255, 255, 255, 0.5); font-size: 3rem;">[:we're sorry for this inconvenience:]</h2>
                <p  style="color:white; font-family: courier;">
                    <a href="#scroll" style="color:white;scroll-behavior: smooth; font-size: 20px;" >as i gently scrolled down...</a>
                </p>
            </center>
            <br><br><br><br><br>
                <?php
            $htmlver = "HTML5";
            $cssver = "CSS3";
            $jsver = "JavaScript";
            $phpver = phpversion();
            $mysqlver = "MySQL";

            echo "<p style='color:white; font-family: courier; margin-left: 10%;'>php version: $phpver</p>";
            echo "<p style='color:white; font-family: courier; margin-left: 10%;'>Html version: $htmlver</p>";
            echo "<p style='color:white; font-family: courier; margin-left: 10%;'>css version: $cssver</p>";
            echo "<p style='color:white; font-family: courier; margin-left: 10%;'>javascript version: $jsver</p>";
            echo "<p style='color:white; font-family: courier; margin-left: 10%;'>mysql version: $mysqlver</p>";
            echo "<p style='color:white; font-family: courier; margin-left: 10%;' id= 'currentDateTime'></p>";
            echo "<h2 style='font-weight: lighter; color:white; font-family: courier; margin-left: 10%;'>Go back to <a style='color:white; font-family: courier;' href='A.T.index.php'>homepage?</a></h2>";
            echo "<br><p style='color:black;'>dont forget to drink!</p>";
            echo "<p style='color:black;'>have you pray today?</p>";
            echo "<p style='color:black;'>...</p>";
            echo "<p style='color:black;'>...</p>";
            ?>
        </div>

    <p id="scroll"></p>
        

</body>
</html>