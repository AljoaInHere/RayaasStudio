<?php
include "database.php";

$nama = $_POST['title'];
$deskripsi = $_POST['description'];
$harga = $_POST['price'];
$kategori = 'digital';

// Logika Upload Gambar
$nama_file = $_FILES['file_product']['name'];
$tmp_file = $_FILES['file_product']['tmp_name'];
$path = "assets/uploads/" . $nama_file;

if (move_uploaded_file($tmp_file, $path)) {
    $query = mysqli_query($conn, "INSERT INTO products (name, description, price, category, image) 
              VALUES ('$nama', '$deskripsi', '$harga', '$kategori', '$nama_file')");
    header("Location: mitra.php");
} else {
    echo "Gagal upload gambar.";
}
?>