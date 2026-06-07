<?php
session_start();
include "database.php";

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$nama = $_POST['nama'];
$metode = $_POST['metode'];

mysqli_query($conn, "INSERT INTO orders (user_id, product_id, nama, metode, status)
VALUES ('$user_id', '$product_id', '$nama', '$metode', 'paid')");

header("Location: dashboard_customer.php?success=1");