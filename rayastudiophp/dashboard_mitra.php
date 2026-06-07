<?php
session_start();

if ($_SESSION['role'] != 'mitra') {
    header("Location: login.php");
    exit();
}
?>
<a href="mitra.php" style="text-decoration: none;">
<h1>Dashboard Mitra</h1>
<p>Halaman ini sedang dalam pengembangan...</p>