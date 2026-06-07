<?php
session_start();
include "database.php";

$product_id = $_GET['product_id'] ?? '';
$paket = $_GET['paket'] ?? '';

$nama_produk = "";
$harga = 0;
$deskripsi = "";

// VALIDASI WAJIB
if (empty($product_id) && empty($paket)) {
    echo "Data tidak ditemukan!";
    exit;
}

/* =========================
   CEK PRODUCT (DIGITAL)
========================= */
if (!empty($product_id)) {
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id'");
    $product = mysqli_fetch_assoc($query);

    if ($product) {
        $nama_produk = $product['name'];
        $harga = $product['price'];
    }
}

/* =========================
   CEK SETUP PACKAGE
========================= */
$paket_list = [
    "VIP" => 100000,
    "VVIP" => 200000,
    "VVIP+" => 300000
];

$deskripsi_list = [
    "VIP" => "Paket basic untuk pemula, cocok untuk setup sederhana.",
    "VVIP" => "Paket menengah dengan fitur lebih lengkap dan profesional.",
    "VVIP+" => "Paket premium full setup + support maksimal."
];

if (!empty($paket) && isset($paket_list[$paket])) {
    $nama_produk = $paket . " Package";
    $harga = $paket_list[$paket];
    $deskripsi = $deskripsi_list[$paket];
}
?>