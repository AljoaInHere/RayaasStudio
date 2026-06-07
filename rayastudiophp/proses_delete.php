<?php
// Memanggil koneksi database
include "database.php";

// Mengecek apakah ada ID yang dikirim dari tombol Delete
if (isset($_GET['id'])) {
    // Mengambil ID produk yang ingin dihapus
    $id = $_GET['id'];

    // Menjalankan perintah SQL untuk menghapus data dari tabel 'products'
    $query = mysqli_query($conn, "DELETE FROM products WHERE id='$id'");

    // Mengecek apakah proses hapus berhasil
    if ($query) {
        // Jika berhasil, langsung arahkan kembali ke halaman dashboard
        header("Location: mitra.php");
        exit(); // Pastikan script berhenti di sini setelah redirect
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    // Jika tidak ada ID yang terdeteksi, kembalikan saja ke dashboard
    header("Location: mitra.php");
    exit();
}
?>