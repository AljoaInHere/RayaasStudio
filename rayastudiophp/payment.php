<?php
session_start();
include "database.php";

$product_id = $_GET['product_id'] ?? '';

$product = null;

if ($product_id) {
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id'");
    $product = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment - Raya</title>
    <link rel="stylesheet" href="style.css?v=20">
</head>
<body>

<div class="payment-container">

    <!-- LEFT -->
    <div class="payment-left">
        <h2>Checkout Now!</h2>

        <p class="product-name"><?= $product['name']; ?></p>
        <p class="price">Rp <?= $product['price']; ?></p>
    </div>

    <!-- RIGHT -->
    <div class="payment-right">
        <h2>Payment</h2>

        <form action="proses_payment.php" method="POST">

            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">

            <label>Nama</label>
            <input type="text" name="nama" required>

            <label>Nama Product</label>
            <input type="text" value="<?= $product['name']; ?>" readonly>

            <label>Metode Pembayaran</label>
            <select name="metode">
                <option value="qris">QRIS</option>
            </select>

            <button type="submit">Bayar Sekarang</button>

        </form>
    </div>

</div>

</body>
</html>