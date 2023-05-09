<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION[''])) {
    header("Location: ./index.php"); // redirects to home.php
}
require_once './db_connect.php';
$id = $_GET['id'];
$query = "SELECT * FROM `animals` WHERE `id` = '$id'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

// check if it is a user or admin and assign the value to $user
$user = isset($_SESSION['user']) ? $_SESSION['user'] : (isset($_SESSION['admn']) ? $_SESSION['admn'] : null);

$layout = '';

$animal_id = $row['id'];
$animal_name = $row['name'];
$animal_age = $row['age'];
$animal_breed = $row['breed'];
$animal_size = $row['size'];
$animal_address = $row['address'];
$animal_description = $row['description'];
$animal_picture = $row['picture'];
$animal_vaccinated = $row['vaccinated'];
$animal_status = $row['status'];

// change 0/1 to text
if ($animal_vaccinated == 1) {
    $animal_vaccinated = 'Vaccinated';
} else {
    $animal_vaccinated = 'Not Vaccinated';
}

if ($animal_status == 1) {
    $animal_status = 'Available';
} else {
    $animal_status = 'Not Available';
}

// adoption logic
if ($animal_status == 'Available') {
    $layout .= '<button type="submit" class="btn btn-block btn-success w-100" name="btn-adopt">adopt me!</button>';

    if (isset($_POST['btn-adopt'])) {
        $adoption_query = "INSERT INTO `adoptions` (`id`, `user_id`, `animal_id`) VALUES (NULL, '$user', '$animal_id')";
        $adoption_result = mysqli_query($connect, $adoption_query);
        if ($adoption_result) {
            $update_status = "UPDATE `animals` SET `status` = '0' WHERE `animals`.`id` = '$animal_id'";
            $update_result = mysqli_query($connect, $update_status);
            echo "<script>alert('Adoption request submitted successfully!');</script>";
            // redirect to home page after notification
            header("refresh:0;url=index.php");
        }
    }
} else {
    $layout .= '<button type="submit" class="btn btn-block btn-success w-100" name="btn-adopt" disabled>adopt me!</button>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details - <?= $animal_name ?></title>
    <?php require_once './bs_css.php' ?>
</head>

<!-- my fix for squishing image -->

<body style="background-image: url('<?= $animal_picture ?>'); height: 100vh; overflow: hidden; background-repeat: no-repeat; background-size: cover; background-position: center;">
    <!-- improved readability -->
    <div style="height: 100vh; width: 100%; background-color: rgba(255,255,255,0.2); box-shadow: 0 0 20vh rgba(0,0,0,1) inset;">
        <?php require_once '../components/_component_Navigation.php' ?>
        <div class="container">
            <span class="display-2">
                <p>hi, my name is</p>
                <h2 class="display-1 fw-bold text-capitalize"><?= $animal_name ?></h2>
                <p>and i am <?= $animal_age ?> years old</p>
            </span>

            <br>

            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <h3 class="display-2">about me</h3>
                    <p class="text-dark fs-1 p-1 px-2"><?= $animal_description ?></p>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <p class="text-dark p-1 px-2" style="background-color: #fff9df;">i am a <?= $animal_breed ?> and i am a <?= $animal_size ?> one</p>
                    <p class="text-dark p-1 px-2" style="background-color: #fff9df;">i live in <?= $animal_address ?></p>
                    <p class="text-dark p-1 px-2" style="background-color: #fff9df;">i am <?= $animal_vaccinated ?></p>
                    <p class="text-dark p-1 px-2" style="background-color: #fff9df;">i am <?= $animal_status ?> to be adopted</p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']); ?>" method="POST">
                        <?= $layout ?>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php require_once './bs_js.php' ?>
</body>

</html>