<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Digital Product - Raya Studio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="mitra-body">

    <div class="mitra-dashboard">
        
        <aside class="mitra-sidebar">
            <div class="mitra-logo">R Y Y</div>
            <div class="mitra-menu-title">MENU</div>
            <nav class="mitra-nav">
                <a href="mitra.php">Home</a>
                <a href="Digital_product.php" class="active">Digital Product</a>
                <a href="Course.php">Course Video</a>
                <a href="#">Setup</a>
                <br><br>
                <a href="logout.php">Log out</a>
            </nav>
        </aside>

        <main class="mitra-main">
            <header class="mitra-header">
                <h1>ADD DIGITAL PRODUCT</h1>
            </header>

            <section class="mitra-card">
                <form action="proses_simpan.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                    
                    <div class="mitra-form-group">
                        <label>Title</label>
                        <input type="text" id="title" name="title" class="mitra-input" placeholder="Masukkan judul produk" required>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div class="mitra-form-group" style="flex: 1;">
                            <label>Price</label>
                            <input type="number" id="price" name="price" class="mitra-input" placeholder="0" required>
                        </div>
                        <div class="mitra-form-group" style="flex: 1;">
                            <label>Currency</label>
                            <select name="currency" class="mitra-input">
                                <option value="IDR">IDR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </div>

                    <div class="mitra-form-group">
                        <label>Description</label>
                        <textarea name="description" class="mitra-input" rows="4" placeholder="Deskripsi produk..."></textarea>
                    </div>

                    <div class="mitra-form-group">
                        <label>Upload Image / File</label>
                        <input type="file" name="file_product" class="mitra-input" required>
                    </div>

                    <button type="submit" class="mitra-btn">Add Digital</button>
                    <div style="clear: both;"></div>
                </form>
            </section>
        </main>
    </div>

    <script>
        function validateForm() {
            var price = document.getElementById("price").value;
            if (price < 0) {
                alert("Harga tidak boleh minus!");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>