<?php
session_start();
include "config/db_connection.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$review = mysqli_real_escape_string($con, $_POST['review']);
$rating = (int) $_POST['rating'];

mysqli_query($con,"
    INSERT INTO reviews (user_id, review, rating, created_at)
    VALUES ($uid,'$review',$rating,NOW())
");

header("Location: index.php#testimonials");
exit;
