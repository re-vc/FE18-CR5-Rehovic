<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: ./home.php"); // redirects to home.php
}
if (isset($_SESSION['admn']) != "") {
    header("Location: ./dashboard.php"); // redirects to dashboard.php
}
require_once './db_connect.php';
$error = false;
$fname = $lname = $email = $date_of_birth = $pass = $picture = $phone = $address = '';
$fnameError = $lnameError = $emailError = $dateError = $passError = $picError = $phoneError = $addressError = '';

function sanitize($str)
{
    return htmlspecialchars(strip_tags(trim($str)));
}

if (isset($_POST['btn-signup'])) {

    // sanitize user input to prevent sql injection
    $fname = sanitize($_POST['fname']);
    $lname = sanitize($_POST['lname']);
    $email = sanitize($_POST['email']);
    $date_of_birth = sanitize($_POST['date_of_birth']);
    $pass = sanitize($_POST['pass']);
    $picture = sanitize($_POST['picture']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);

    // basic name validation
    if (empty($fname) || empty($lname)) {
        $error = true;
        $fnameError = "Please enter your full name and surname";
    } else if (strlen($fname) < 3 || strlen($lname) < 3) {
        $error = true;
        $fnameError = "Name and surname must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
        $error = true;
        $fnameError = "Name and surname must contain only letters and no spaces.";
    }

    // basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }

    // basic phone validation
    if (empty($phone)) {
        $error = true;
        $phoneError = "Please enter your phone number.";
    } else if (strlen($phone) < 10) {
        $error = true;
        $phoneError = "Phone number must have at least 10 characters.";
    } else if (!preg_match("/^[0-9+\s]+$/", $phone)) {
        $error = true;
        $phoneError = "Phone number must contain only numbers and no spaces.";
    }

    // basic address validation
    if (empty($address)) {
        $error = true;
        $addressError = "Please enter your address.";
    } else if (strlen($address) < 10) {
        $error = true;
        $addressError = "Address must have at least 10 characters.";
    }

    // basic date validation
    if (empty($date_of_birth)) {
        $error = true;
        $dateError = "Please enter your date of birth.";
    }

    // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }
    // password hashing for security
    $password = hash('sha256', $pass);
    // if there's no error, continue to signup
    if (!$error) {

        $query = "INSERT INTO users(first_name, last_name, email, date_of_birth, password, picture, phone, address)
        VALUES('$fname','$lname','$email','$date_of_birth','$password','$picture','$phone','$address')";

        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <?php require_once './bs_css.php' ?>
</head>

<body>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
            <h1 class="display-1">SignUp</h1>
            <div class="my-5"></div>

            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert alert-<?php echo $errTyp ?>">
                    <p><?php echo $errMSG; ?></p>
                </div>
            <?php
            }
            ?>

            <input type="text" name="fname" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $fname ?>" />
            <span class="text-danger"> <?php echo $fnameError ?> </span>

            <input type="text" name="lname" class="form-control" placeholder="Surname" maxlength="50" value="<?php echo $lname ?>" />
            <span class="text-danger"> <?php echo $fnameError ?> </span>

            <input class='form-control' type="date" name="date_of_birth" value="<?php echo $date_of_birth ?>" />
            <span class="text-danger"> <?php echo $dateError ?> </span>

            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            <span class="text-danger"> <?php echo $emailError ?> </span>

            <input type="text" name="phone" class="form-control" placeholder="Phone number" maxlength="50" value="<?php echo $phone ?>" />
            <span class="text-danger"> <?php echo $phoneError ?> </span>

            <input type="text" name="address" class="form-control" placeholder="Address" maxlength="50" value="<?php echo $address ?>" />
            <span class="text-danger"> <?php echo $addressError ?> </span>

            <input type="text" name="picture" class='form-control' placeholder="Picture URL" value="<?php echo $picture ?>" />
            <span class="text-danger"> <?php echo $picError ?> </span>

            <input type="password" name="pass" class="form-control" placeholder="Enter Password" />
            <span class="text-danger"> <?php echo $passError ?> </span>

            <br>

            <button type="submit" class="btn btn-block btn-primary my-2" name="btn-signup">Sign Up</button>

            <a href="./login.php" class="mx-3">Sign in Here...</a>
        </form>
    </div>
</body>

</html>