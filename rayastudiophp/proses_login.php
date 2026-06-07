<?php
session_start();
include "database.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($query);

if ($user && $password == $user['password']) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'customer') {
        header("Location: dashboard_customer.php");
    } else {
        header("Location: mitra.php");
    }
    exit();

} else {
    header("Location: login.php?error=1");
    exit();
}
