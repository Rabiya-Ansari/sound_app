<?php
include 'auth.php';
session_destroy();
header("Location: /sound/index.php");
?>