<?php
include 'auth.php';
include '../config/db_connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = "Invalid user ID!";
    $_SESSION['message_type'] = "error";
    header("Location: users.php");
    exit;
}

$id = (int) $_GET['id'];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$_SESSION['message'] = "User deleted successfully!";
$_SESSION['message_type'] = "success";

header("Location: users.php");
exit;
