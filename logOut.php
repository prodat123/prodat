<?php
    SESSION_START();

    $_SESSION['Username'] = "";
    $_SESSION['Channel'] = "";
    header("Location: HomePage.php");
?>

