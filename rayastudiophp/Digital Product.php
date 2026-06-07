<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Digital Product - Raya Studio</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Kita tambahkan style khusus halaman ini agar fokus di tengah */
        body {
            background-color: #f3f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container-focus {
            width: 100%;
            max-width: 550px;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #521475; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none;
        }
        .btn-save {
            background-color: #521475; color: white; border: none; width: 100%;
            padding: 15px; border-radius: 30px; font-weight: bold; cursor: pointer;
        }
        .btn-cancel {
            display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container-focus">
    <h2 style="margin-bottom: 25px; text-align: center; color: #521475;">Digital Product</h2>
    
    <form action="proses_simpan.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="gambar_produk" required>
        </div>

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="judul" placeholder="Judul Produk Digital">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="deskripsi" rows="4" placeholder="Deskripsi produk..."></textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <div class="form-group" style="flex: 2;">
        <div class="form-group">
    <label>Product Link / URL</label>
    <input type="url" name="link_produk" placeholder="https://drive.google.com/..." required>
    <small style="color: #888; font-size: 11px;">*Masukkan link download atau link platform (G-Drive/Dropbox)</small>
</div>
                <label>Price (IDR)</label>
                <input type="number" name="harga" value="0">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Platform</label>
                <select name="platform">
                    <option value="G-Drive">G-Drive</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn-save">Add Digital</button>
        <a href="mitra.php" class="btn-cancel">Cancel / Kembali ke Dashboard</a>
    </form>
</div>

</body>
</html>