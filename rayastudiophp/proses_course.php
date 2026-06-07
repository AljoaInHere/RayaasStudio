<?php
session_start();
include "database.php";

$nama = $_POST['video_title'];
$deskripsi = $_POST['description'];
// Harga bisa kamu ambil dari form jika ada, atau di-set default
$harga = 0; 

// Memasukkan data ke tabel products dengan kategori 'course'
$query = mysqli_query($conn, "INSERT INTO products (name, description, price, category) VALUES ('$nama', '$deskripsi', '$harga', 'course')");
if($query) {
    header("Location: mitra.php");
} else {
    echo "Gagal menambahkan course video: " . mysqli_error($conn);
}
?>