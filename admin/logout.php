<?php
session_start();
session_destroy();
header("Location: /sound/index.php");
?>