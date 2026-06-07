<?php
session_start();
include "database.php";

// ambil data dari form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$role = $_POST['role'];

// cek password sama atau nggak
if ($password != $confirm) {
    echo "Password tidak sama!";
    exit();
}

// cek email sudah ada atau belum
$cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if (mysqli_num_rows($cek) > 0) {
    echo "Email sudah digunakan!";
    exit();
}

// simpan ke database
$query = mysqli_query($conn, "INSERT INTO users (username, email, password, role) 
VALUES ('$username', '$email', '$password', '$role')");

// cek berhasil atau nggak
if ($query) {
    header("Location: login.php?success=1");
    exit();
} else {
    die("Query gagal: " . mysqli_error($conn));
}
?>
