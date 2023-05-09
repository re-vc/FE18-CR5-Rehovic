<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['admn']) != "") {
    header("Location: ./dashboard.php"); // redirects to dashboard.php
}
if (!isset($_SESSION['user'])) {
    header("Location: ./index.php"); // redirects to home.php
}
require_once './db_connect.php';
$sql = "SELECT * FROM `animals`";
$result = mysqli_query($connect, $sql);
$layout = "";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $layout .= "<tr>";
        $layout .= "<td class='lnh'>" . $row['id'] . "</td>";
        $layout .= "<td class='lnh'>" . "<img class='img-thumbnail' style='width: 16rem' src='{$row['picture']}'></img>" . "</td>";
        $layout .= "<td class='lnh'>" . $row['name'] . "</td>";
        $layout .= "<td class='lnh'>" . $row['breed'] . "</td>";
        if ($row['status'] == '1') {
            $layout .= "<td class='lnh'>" . "<span class='badge bg-success'>availible</span>" . "</td>";
        } else {
            $layout .= "<td class='lnh'>" . "<span class='badge bg-danger'>reserved</span>" . "</td>";
        }
        $layout .= "<td>" . "<a class='btn btn-secondary text-decoration-none text-white' href='./details.php?id={$row['id']}'>details</a>" . "</td>";
        $layout .= "</tr>";
    }
} else {
    $layout = "<tr><td colspan='4'>No data found</td></tr>";
}

// Filter
if (isset($_GET['btn-filter'])) {
    $filter = $_GET['filter'];
    switch ($filter) {
        case 'available':
            $sql = "SELECT * FROM `animals` WHERE `status` = '1'";
            break;
        case 'reserved':
            $sql = "SELECT * FROM `animals` WHERE `status` = '0'";
            break;
        case 'senior':
            $sql = "SELECT * FROM `animals` WHERE `age` >= 8";
            break;
        case 'young':
            $sql = "SELECT * FROM `animals` WHERE `age` <= 7";
            break;
        default:
            $sql = "SELECT * FROM `animals`";
            break;
    }

    $result = mysqli_query($connect, $sql);
    $layout = "";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $layout .= "<tr>";
            $layout .= "<td class='lnh'>" . $row['id'] . "</td>";
            $layout .= "<td class='lnh'>" . "<img class='img-thumbnail' style='width: 16rem' src='{$row['picture']}'></img>" . "</td>";
            $layout .= "<td class='lnh'>" . $row['name'] . "</td>";
            $layout .= "<td class='lnh'>" . $row['breed'] . "</td>";
            if ($row['status'] == '1') {
                $layout .= "<td class='lnh'>" . "<span class='badge bg-success'>availible</span>" . "</td>";
            } else {
                $layout .= "<td class='lnh'>" . "<span class='badge bg-danger'>reserved</span>" . "</td>";
            }
            $layout .= "<td>" . "<a class='btn btn-secondary text-decoration-none text-white' href='./details.php?id={$row['id']}'>details</a>" . "</td>";
            $layout .= "<td>" . "<a class='btn btn-primary text-decoration-none text-white' href='./edit.php?id={$row['id']}'>edit</a>" . "</td>";
            $layout .= "<td>" . "<a class='btn btn-danger text-decoration-none text-white' href='./delete.php?id={$row['id']}'>delete</a>" . "</td>";
            $layout .= "</tr>";
        }
    } else {
        $layout = "<tr><td colspan='4'>No data found</td></tr>";
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
    <?php require_once './bs_css.php' ?>
    <style>
        .lnh {
            line-height: 2.5rem;
        }
    </style>
</head>

<body>
    <?php require_once '../components/_component_Navigation.php' ?>
    <div class="container">

        <form class="d-flex gap-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <select class="form-control my-2 text-center" id="filter" name="filter">
                <!-- creating selecetion and keep/remember the selection -->
                <option value="all" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'all') echo 'selected'; ?>>All</option>
                <option value="available" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'available') echo 'selected'; ?>>Available</option>
                <option value="reserved" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'reserved') echo 'selected'; ?>>Reserved</option>
                <option value="senior" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'senior') echo 'selected'; ?>>Senior</option>
                <option value="young" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'young') echo 'selected'; ?>>Young</option>
            </select>
            <button type="submit" class="btn btn-block btn-primary my-2" name="btn-filter">Filter</button>
        </form>

        <table class="table my-5">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">image</th>
                    <th scope="col">name</th>
                    <th scope="col">breed</th>
                    <th scope="col">status</th>
                    <th scope="col">details</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $layout; ?>
            </tbody>
        </table>
    </div>
    <?php require_once './bs_js.php' ?>
</body>

</html>