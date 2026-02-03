<?php
include "./auth.php";
include "../config/db_connection.php";

$id = (int)$_GET['id'];

$res = mysqli_fetch_assoc(mysqli_query($con,"SELECT image FROM events WHERE id=$id"));
if($res && file_exists("../media/".$res['image'])){
    unlink("../media/".$res['image']);
}

mysqli_query($con,"DELETE FROM events WHERE id=$id");
header("Location: all_events.php");
exit;
