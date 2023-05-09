<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: ./home.php"); // redirects to home.php
}
if (!isset($_SESSION['admn'])) {
    header("Location: ./index.php"); // redirects to index.php
}
require_once 'db_connect.php';
$error = false;
$animal_picture = $animal_name = $animal_age = $animal_breed = $animal_size = $animal_address = $animal_description = $animal_vaccinated = $animal_status = '';
$animal_pictureError = $animal_nameError = $animal_ageError = $animal_breedError = $animal_sizeError = $animal_addressError = $animal_descriptionError = $animal_vaccinatedError = $animal_statusError = '';

function sanitize($str)
{
    return htmlspecialchars(strip_tags(trim($str)));
}

if (isset($_POST['btn-create'])) {

    // sanitize user input to prevent sql injection
    $animal_picture = sanitize($_POST['picture']);
    $animal_name = sanitize($_POST['name']);
    $animal_age = sanitize($_POST['age']);
    $animal_breed = sanitize($_POST['breed']);
    $animal_size = sanitize($_POST['size']);
    $animal_address = sanitize($_POST['address']);
    $animal_description = sanitize($_POST['description']);
    $animal_vaccinated = sanitize($_POST['vaccinated']);
    $animal_status = sanitize($_POST['status']);

    // basic picture validation
    if (!empty($animal_picture) && !filter_var($animal_picture, FILTER_VALIDATE_URL)) {
        $error = true;
        $animal_pictureError = "Please enter a valid picture url";
    }

    // basic name validation
    if (empty($animal_name)) {
        $error = true;
        $animal_nameError = "Please enter a name";
    } else if (strlen($animal_name) < 2) {
        $error = true;
        $animal_nameError = "Name must have at least 2 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $animal_name)) {
        $error = true;
        $animal_nameError = "Name must contain only letters and no spaces.";
    }

    // basic age validation
    if (empty($animal_age)) {
        $error = true;
        $animal_ageError = "Please enter an age";
    } else if (!is_numeric($animal_age) || $animal_age < 0) {
        $error = true;
        $animal_ageError = "Age must be a number";
    }

    // basic address validation
    if (empty($animal_address)) {
        $error = true;
        $animal_addressError = "Please enter an address";
    } else if (strlen($animal_address) < 3) {
        $error = true;
        $animal_addressError = "Address must have at least 3 characters.";
    }

    // basic description validation
    if (!empty($animal_description) && strlen($animal_description) < 3) {
        $error = true;
        $animal_descriptionError = "Description must have at least 3 characters.";
    }

    if (!$error) {
        $sql = "INSERT INTO animals (picture, name, age, breed, size, address, description, vaccinated, status) VALUES ('$animal_picture', '$animal_name', '$animal_age', '$animal_breed', '$animal_size', '$animal_address', '$animal_description', '$animal_vaccinated', '$animal_status')";
        if (mysqli_query($connect, $sql)) {
            header("Location: ./index.php"); // redirects to index.php
        } else {
            echo "Error " . $sql . ' ' . mysqli_connect_error($connect);
        }
        mysqli_close($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdoptPets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <?php require_once '../components/_component_Navigation.php' ?>
    <div class="container">

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group">
                <input class="form-control my-2 text-center" type="text" placeholder="please specify an picture url" name="picture" maxlength="255" value="<?php echo $animal_picture ?>">
                <span class="text-danger"> <?php echo $animal_pictureError ?> </span>

                <input class="form-control my-2 text-center" type="text" placeholder="please specify a name" name="name" maxlength="50" value="<?php echo $animal_name ?>">
                <span class="text-danger"> <?php echo $animal_nameError ?> </span>

                <input class="form-control my-2 text-center" type="number" placeholder="please specify an age" name="age" value="<?php echo $animal_age ?>">
                <span class="text-danger"> <?php echo $animal_ageError ?> </span>

                <input class="form-control my-2 text-center" type="text" placeholder="please specify a breed" name="breed" maxlength="50" value="<?php echo $animal_breed ?>">
                <span class="text-danger"> <?php echo $animal_breedError ?> </span>

                <!-- create selection for size, no validation because of selection of predefined values and defaults in db -->
                <!-- not sure if this is secure against sql injection though. -->
                <select class="form-control my-2 text-center" id="exampleFormControlSelect2" name="size">
                    <option value="large">size of animal - large</option>
                    <option value="small">size of animal - small</option>
                </select>

                <input class="form-control my-2 text-center" type="text" placeholder="please specify an address" name="address" maxlength="50" value="<?php echo $animal_address ?>">
                <span class="text-danger"> <?php echo $animal_addressError ?> </span>

                <input class="form-control my-2 text-center" type="text" placeholder="please specify a description" name="description" value="<?php echo $animal_description ?>">
                <span class="text-danger"> <?php echo $animal_descriptionError ?> </span>
                
                <!-- create selection for vaccinated -->
                <!-- i tried using bit to store this but had issues so i changed it to tinyint(1) -->
                <select class="form-control my-2 text-center" id="exampleFormControlSelect2" name="vaccinated">
                    <option value="0">is vaccinated - no</option>
                    <option value="1">is vaccinated - yes</option>
                </select>
                
                <!-- create selection for status -->                
                <select class="form-control my-2 text-center" id="exampleFormControlSelect2" name="status">
                    <option value="0">reserved</option>
                    <option value="1">available for adoption</option>
                </select>

                <button class='btn btn-success text-decoration-none text-white w-100' type="submit" name="btn-create">create</button>
                <a class='btn btn-secondary text-decoration-none text-white w-100 my-1' href='./index.php'>back</a>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>