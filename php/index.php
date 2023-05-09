<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: ./home.php"); // redirects to home.php
}
if (isset($_SESSION['admn']) != "") {
    header("Location: ./dashboard.php"); // redirects to dashboard.php
}
require_once './db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdoptPets</title>
    <?php require_once './bs_css.php' ?>
    <link rel="shortcut icon" href="http://cdn.onlinewebfonts.com/svg/img_80555.png">
</head>

<body>
    <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <?php require_once '../components/_component_Navigation.php' ?>
    </div>
    <?php require_once './bs_js.php' ?>
</body>

</html>