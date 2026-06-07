<?php
session_start();
include "database.php";

// Ambil user login
$user_id = $_SESSION['user_id'];

// Ambil data dari form
$paket  = $_POST['paket'];
$nama   = $_POST['nama'];
$metode = $_POST['metode'];

// Set harga berdasarkan paket
$paket_list = [
    "VIP" => 100000,
    "VVIP" => 200000,
    "VVIP+" => 300000
];

// Validasi paket
if (!isset($paket_list[$paket])) {
    echo "Paket tidak valid!";
    exit;
}

$harga = $paket_list[$paket];

// Simpan ke database
mysqli_query($conn, "INSERT INTO orders (user_id, paket, harga, nama, metode, status)
VALUES ('$user_id', '$paket', '$harga', '$nama', '$metode', 'paid')");

// Redirect
header("Location: dashboard_customer.php?success=1");
exit;
?>