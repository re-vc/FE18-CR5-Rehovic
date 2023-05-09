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
$email = $pass = '';
$emailError = $passError = '';

function sanitize($str)
{
    return htmlspecialchars(strip_tags(trim($str)));
}

if (isset($_POST['btn-login'])) {

    // sanitize user input to prevent sql injection
    $email = sanitize($_POST['email']);
    $pass = sanitize($_POST['pass']);

    // basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            $error = true;
            $emailError = "Provided Email is not registered.";
        }
    }

    // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else {
        // password hashing to get the encrypted password
        $password = hash('sha256', $pass);
        // checks whether the encrypted password is correct or not
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            $error = true;
            $passError = "The password you entered is incorrect.";
        } elseif ($row['status'] == 'admn') {
            $_SESSION['admn'] = $row['id'];
            header('Location: dashboard.php');
        } else {
            $_SESSION['user'] = $row['id'];
            header("Location: home.php");
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
    <title>LogIn</title>
    <?php require_once './bs_css.php' ?>
</head>

<body>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="on" enctype="multipart/form-data">
            <h1 class="display-1">LogIn</h1>
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

            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            <span class="text-danger"> <?php echo $emailError; ?> </span>

            <input type="password" name="pass" class="form-control" placeholder="Enter Password" />
            <span class="text-danger"> <?php echo $passError; ?> </span>

            <br>

            <button type="submit" class="btn btn-block btn-primary my-2" name="btn-login">Login</button>            

            <a href="./register.php" class="mx-3">Sign up Here...</a>
        </form>
    </div>
</body>

</html>