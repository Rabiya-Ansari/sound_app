
<?php
include 'auth.php';
include '../config/db_connection.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    mysqli_query($con,"DELETE FROM reviews WHERE id=$id");
}

header("Location: reviews.php");
?>