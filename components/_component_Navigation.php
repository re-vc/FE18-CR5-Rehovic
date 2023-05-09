<?php
// check if it is a user or admin and assign the value to $user
$user = isset($_SESSION['user']) ? $_SESSION['user'] : (isset($_SESSION['admn']) ? $_SESSION['admn'] : null);
require_once '../php/db_connect.php';
$user_query = "SELECT * FROM `users` WHERE `id` = '$user'";
$user_result = mysqli_query($connect, $user_query);
$user_row = mysqli_fetch_assoc($user_result);
$user_info = '';
if (mysqli_num_rows($user_result) > 0) {
    $name = $user_row['first_name'] . " " . $user_row['last_name'];
    $picture = $user_row['picture'];
    $user_info .= '<div class="btn pe-none text-nowrap">' . $name . '</div>';
    // if admin, add a red border to the picture
    if ($user_row['status'] == 'admn') {
        $user_info .= '<img class="img-thumbnail pe-none mx-1" style="height: 38px; padding: 0; border: solid 1px red;" src="' . $picture . '"></img>';
    } else {
        $user_info .= '<img class="img-thumbnail pe-none mx-1" style="height: 38px; padding: 0" src="' . $picture . '"></img>';
    }
}

?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-1">
            <a class="text-dark" href="./index.php">AdoptPets</a>
        </h1>
        <div class="d-flex">
            <?= $user_info ?>
            <?php
            if (isset($_SESSION['user']) != "" || isset($_SESSION['admn']) != "") {
                echo '<a href="./logout.php?logout" class="btn btn-danger">LogOut</a>';
            } else {
                echo '<a href="./register.php" class="btn btn-outline-secondary">Register</a>';
                echo '<a href="./login.php" class="btn btn-primary mx-1">LogIn</a>';                
            }
            ?>
        </div>
    </div>
    <div class="my-5"></div>
</div>