<?php
session_start();
include 'config/db_connection.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = sha1($_POST['password']); 

    $res = mysqli_query($con,
        "SELECT * FROM users 
         WHERE email='$email' AND password='$password'"
    );

    if(mysqli_num_rows($res) == 1){
        $user = mysqli_fetch_assoc($res);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if($user['role'] == 'admin'){
            header("Location: /sound/admin/index.php");
        } else {
            header("Location: /sound/user/dashboard.php");
        }
        exit;
    } else {
        echo " Invalid Email or Password";
    }
}
?>



<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>
