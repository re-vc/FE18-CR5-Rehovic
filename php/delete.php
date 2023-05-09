<?php
require_once 'db_connect.php';
$id = $_GET['id'];
$sql = "DELETE FROM animals WHERE id = {$id}";
if (mysqli_query($connect, $sql) === true) {
    header("Location: ./index.php");
} else {
    echo "Error updating record : " . $connect->error;
}
?>
