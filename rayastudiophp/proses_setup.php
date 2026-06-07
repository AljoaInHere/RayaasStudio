<?php
include "database.php";

$nama = $_POST['fullname'];
$deskripsi = $_POST['description'];
$harga = $_POST['price'];
$kategori = 'setup';

$nama_file = $_FILES['tech_photo']['name'];
$tmp_file = $_FILES['tech_photo']['tmp_name'];
$path = "assets/uploads/" . $nama_file;

if (move_uploaded_file($tmp_file, $path)) {
    $query = mysqli_query($conn, "INSERT INTO products (name, description, price, category, image) 
              VALUES ('$nama', '$deskripsi', '$harga', '$kategori', '$nama_file')");
    header("Location: mitra.php");
}
?>