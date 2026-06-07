<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mitra') {
    header("Location: login.php");
    exit();
}
include "database.php";

$user_id = $_SESSION['user_id'] ?? null;
$user = null;
$profile_photo = $_SESSION['profile_photo'] ?? '';
$profile_bio = $_SESSION['profile_bio'] ?? '';
$profile_birth_place = $_SESSION['profile_birth_place'] ?? '';
$profile_birth_date = $_SESSION['profile_birth_date'] ?? '';

if ($user_id) {
    $user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
    if ($user_query) {
        $user = mysqli_fetch_assoc($user_query);
    }
}

// Pagination config
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Total items count query
$countSql = "SELECT COUNT(*) as total FROM products";
$countResult = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countResult);
$total = $countRow['total'];
$totalPages = ceil($total / $limit);

// Paginated query
$query_products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT $offset, $limit");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra - Raya Studio</title>
    
    <style>
        /* =========================================
   CSS UNTUK DAFTAR PRODUK DI DASHBOARD MITRA
   ========================================= */
.my-products-section {
    margin-top: 35px;
    border-top: 1px solid #f0f0f0;
    padding-top: 20px;
}

.my-products-title {
    font-size: 16px;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
}

.product-list-card {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 1px solid #eaeaea;
    border-radius: 12px;
    margin-bottom: 15px;
    background: #fafafa;
    transition: 0.3s;
}

.product-list-card:hover {
    border-color: #521475;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.03);
}

.plc-icon {
    width: 50px;
    height: 50px;
    background: #f5eef9;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-right: 15px;
}

.plc-info {
    flex: 1;
}

.plc-title {
    font-weight: bold;
    color: #333;
    font-size: 15px;
    margin-bottom: 4px;
}

.plc-category {
    font-size: 11px;
    font-weight: bold;
    color: #521475;
    background: #f5eef9;
    padding: 3px 8px;
    border-radius: 4px;
    display: inline-block;
    margin-right: 10px;
}

.plc-price {
    font-size: 13px;
    color: #666;
    font-weight: 600;
}

.plc-actions {
    display: flex;
    gap: 10px;
}

.plc-btn-edit {
    color: #17a2b8;
    background: #e0f4f7;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    font-size: 12px;
}

.plc-btn-delete {
    color: #dc3545;
    background: #fceceb;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    font-size: 12px;
}
        /* =========================================
           CSS UTAMA DASHBOARD
           ========================================= */
        body.mitra-page {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f6f6;
        }

        .mitra-layout {
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .mitra-sidebar {
            width: 280px;
            background-color: #4f1d70; 
            color: white;
            padding: 40px 30px;
            box-sizing: border-box;
            position: fixed;
            height: 100vh;
        }
        .logout-item {
    position: absolute;
    bottom: 30px;
    left: 30px;
}
.logout-item a {
    display: inline-block;
    color: white;
    font-size: 14px;
    text-decoration: none;
    padding: 10px 16px;
    border-radius: 12px;
    background: rgba(255,255,255,0.12);
    transition: background 0.3s;
}
.logout-item a:hover {
    background: rgba(255,255,255,0.2);
}

.mitra-nav-list li.active a {
    color: #ffffff;
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    padding: 10px 14px;
}
        .mitra-logo-text { font-size: 38px; font-weight: 900; letter-spacing: 4px; margin: 0; }
        .mitra-logo-sub { font-size: 9px; letter-spacing: 1px; margin-bottom: 50px; display: block; }
        .mitra-menu-label { font-size: 13px; font-weight: bold; margin-bottom: 40px; letter-spacing: 1px; }
        .mitra-nav-list { list-style: none; padding: 0; margin: 0; }
        .mitra-nav-list li { margin-bottom: 25px; }
        .mitra-nav-list a { color: white; text-decoration: none; font-size: 20px; font-weight: bold; transition: 0.3s opacity; }
        .mitra-nav-list a:hover { opacity: 0.8; }

        /* --- KONTEN KANAN --- */
        .mitra-content { flex: 1; padding: 60px 50px; position: relative; margin-left: 280px;}
        .mitra-content h1 { font-size: 34px; font-weight: 800; color: #111; margin-top: 0px; margin-bottom: 40px; }

        /* --- CARD & BANNER --- */
        .mitra-card { background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 850px; }
        .mitra-card-header { display: flex; align-items: center; margin-bottom: 20px; }
        .mitra-card-label { font-weight: bold; color: #888; font-size: 13px; margin-right: 30px; }
        .mitra-btn-upgrade { border: 1px solid #1d1d2d; background: transparent; color: #1d1d2d; padding: 6px 16px; border-radius: 6px; font-weight: bold; font-size: 12px; cursor: pointer; }
        .mitra-arrow-icon { margin-left: auto; font-size: 26px; color: #777; }
        
        .mitra-profile-banner { background-color: #6b3e8e; border-radius: 50px; padding: 12px 20px; display: flex; align-items: center; margin-bottom: 40px; }
        .mitra-avatar { width: 50px; height: 50px; background-color: rgba(255, 255, 255, 0.4); border-radius: 50%; margin-right: 20px; }
        .mitra-profile-info { flex: 1; }
        .mitra-profile-name { font-weight: bold; color: #4f1d70; font-size: 14px; margin: 0 0 3px 0; }
        .mitra-profile-link { color: #4f1d70; font-size: 13px; margin: 0; font-weight: bold; }
        .mitra-btn-share { background: #fff; color: #4f1d70; border: none; padding: 10px 25px; border-radius: 30px; font-weight: bold; font-size: 13px; cursor: pointer; }

        /* --- TOMBOL AKSI --- */
        .mitra-actions-scroll { display: flex; gap: 15px; overflow-x: auto; padding-bottom: 15px; }
        .mitra-actions-scroll::-webkit-scrollbar { height: 8px; }
        .mitra-actions-scroll::-webkit-scrollbar-track { background: #eee; border-radius: 10px; }
        .mitra-actions-scroll::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
        
        .mitra-action-btn { background-color: #dbdbdb; color: #777; border: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 12px; cursor: pointer; white-space: nowrap; }
        .mitra-action-btn:hover { background-color: #c9c9c9; color: #555; }

        /* =========================================
           CSS MODAL POP-UP (BOTTOM SHEET)
           ========================================= */
        .mitra-modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: flex-end; /* Membuat modal nempel di bawah */
            
            /* Animasi Fade In Background */
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .mitra-modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .mitra-modal-container {
            background: white;
            width: 100%;
            max-width: 800px;
            padding: 30px 40px 50px 40px;
            border-radius: 24px 24px 0 0; /* Melengkung di atas saja */
            box-sizing: border-box;
            max-height: 85vh;
            overflow-y: auto;
            
            /* Animasi Slide Up dari bawah */
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .mitra-modal-overlay.active .mitra-modal-container {
            transform: translateY(0);
        }

        .mitra-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }

        .mitra-modal-header h2 { margin: 0; font-size: 24px; color: #333; }
        
        .mitra-close-btn {
            background: none; border: none; font-size: 28px; color: #888;
            cursor: pointer; font-weight: bold; transition: color 0.2s;
        }
        .mitra-close-btn:hover { color: #d9534f; }

        /* Style Form di dalam Modal */
        .mitra-form-group { margin-bottom: 20px; }
        .mitra-form-group label { display: block; margin-bottom: 8px; color: #555; font-weight: bold; font-size: 14px; }
        .mitra-input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px; font-family: inherit; }
        .mitra-input:focus { outline: none; border-color: #6b3e8e; }
        
        .mitra-submit-btn {
            background-color: #20b2aa; /* Warna tosca khas tombol submit lynk.id */
            color: white; border: none; padding: 14px 30px; border-radius: 8px;
            font-weight: bold; font-size: 16px; cursor: pointer; float: right; margin-top: 10px;
        }
        .mitra-submit-btn:hover { background-color: #1a968f; }
        /* =========================================
           CSS KHUSUS MODAL COURSE VIDEO
           ========================================= */
        .mitra-tabs { display: flex; gap: 10px; margin-bottom: 10px; }
        .mitra-tab {
            padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer;
            font-weight: bold; font-size: 13px; background-color: #f0e6f5; color: #552b7b; transition: 0.3s;
        }
        .mitra-tab.active { background-color: #4f1d70; color: white; }
        
        .mitra-upload-box {
            border: 2px dashed #ddd; border-radius: 12px; height: 100px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            cursor: pointer; color: #6b3e8e; background-color: #fafafa; transition: 0.3s;
        }
        .mitra-upload-box:hover { border-color: #4f1d70; background-color: #f3e8ff; }
        /* =========================================
           CSS MODAL UPGRADE TO PRO (PREMIUM LOOK)
           ========================================= */
        .pro-modal-content {
            text-align: center;
            padding-bottom: 20px;
        }

        .pro-badge {
            background: linear-gradient(45deg, #ffd700, #ffa500);
            color: #4f1d70;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .pro-price-tag {
            font-size: 32px;
            font-weight: 900;
            color: #4f1d70;
            margin: 10px 0;
        }

        .pro-features-list {
            text-align: left;
            background: #f8f4ff;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            list-style: none;
        }

        .pro-features-list li {
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
            display: flex;
            align-items: center;
        }

        .pro-features-list li::before {
            content: '✓';
            color: #4f1d70;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Desain Pilihan Pembayaran */
        .payment-methods {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            margin-top: 20px;
        }

        .payment-option {
            border: 2px solid #eee;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .payment-option:hover, .payment-option.selected {
            border-color: #4f1d70;
            background: #f5eeff;
        }

        .payment-option img {
            height: 20px;
            display: block;
            margin: 0 auto;
        }
        .plc-image {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            margin-right: 15px;
            border: 1px solid #f0f0f0;
        }

        /* Fullscreen Logout Overlay Loader */
        .logout-overlay {
            position: fixed;
            inset: 0;
            background: rgba(4, 4, 8, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .logout-overlay.visible {
            display: flex;
            opacity: 1;
        }
        .logout-box {
            text-align: center;
            animation: logoutPulse 1.2s infinite ease-in-out;
            font-family: Arial, sans-serif;
        }
        .logout-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(157, 78, 221, 0.15);
            border-top: 3px solid #9d4edd;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            animation: logoutSpin 1s linear infinite;
            box-shadow: 0 0 15px rgba(157, 78, 221, 0.15);
        }
        .logout-box h3 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 8px;
            color: #fff;
        }
        .logout-box p {
            color: #9ca3af;
            font-size: 14px;
        }
        @keyframes logoutSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes logoutPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }
        @media (max-width: 768px) {
            .mitra-layout {
                flex-direction: column;
            }
            .mitra-sidebar {
                width: 100% !important;
                height: auto !important;
                position: relative !important;
                padding: 20px !important;
            }
            .mitra-logo-sub {
                margin-bottom: 20px !important;
            }
            .mitra-menu-label {
                display: none !important;
            }
            .mitra-nav-list {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 15px !important;
                margin-bottom: 0 !important;
            }
            .mitra-nav-list li {
                margin-bottom: 0 !important;
            }
            .logout-item {
                position: relative !important;
                bottom: auto !important;
                left: auto !important;
            }
            .mitra-content {
                margin-left: 0 !important;
                padding: 30px 20px !important;
            }
            .mitra-profile-banner {
                flex-direction: column !important;
                border-radius: 24px !important;
                text-align: center !important;
                gap: 15px !important;
                padding: 20px !important;
            }
            .mitra-avatar {
                margin-right: 0 !important;
            }
            .mitra-btn-share {
                width: 100% !important;
            }
            .mitra-actions-scroll {
                flex-wrap: wrap !important;
            }
            .product-list-card {
                flex-direction: column !important;
                text-align: center !important;
            }
            .plc-image {
                margin-right: 0 !important;
            }
            .plc-actions {
                width: 100% !important;
                justify-content: center !important;
                margin-top: 10px !important;
            }
        }

        /* Sliding Active Pill/Tab Indicator */
        .sliding-pill-indicator {
            position: absolute;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 0;
            transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
            pointer-events: none;
            opacity: 0;
        }

        /* Ensure menu items stack above the pill */
        .mitra-nav-list {
            position: relative !important;
        }

        .mitra-nav-list li, .mitra-nav-list a {
            position: relative;
            z-index: 1;
        }

        .mitra-nav-list li.active a {
            background: transparent !important;
        }
    </style>
</head>
<body class="mitra-page">

    <div class="mitra-layout">
        
        <aside class="mitra-sidebar">
            <div style="margin-bottom: 40px;">
                <h1 class="mitra-logo-text">R°Y°/</h1>
                <span class="mitra-logo-sub">CREATIVE STUDIO</span>
            </div>
            <div class="mitra-menu-label">MENU</div>
            <ul class="mitra-nav-list">
                <li class="<?= basename($_SERVER['PHP_SELF']) == 'mitra.php' ? 'active' : '' ?>"><a href="mitra.php">Home</a></li>
                <li class="<?= basename($_SERVER['PHP_SELF']) == 'setup.php' ? 'active' : '' ?>"><a href="setup.php">Set up</a></li>
                <li class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>"><a href="profile.php">Profil</a></li>
                <br>
                <li class="logout-item">
                    <a href="logout.php" onclick="triggerLogout(event)">Log out</a>
                </li>
            </ul>
        </aside>

        <main class="mitra-content">
            <h1>HOME</h1>

            <div class="mitra-card">
                <div class="mitra-card-header">
                    <button class="mitra-btn-upgrade" onclick="openUpgradeModal()">Upgrade to pro</button>
                    <span class="mitra-arrow-icon">›</span>
                </div>

                <div class="mitra-profile-banner">
                    <div class="mitra-avatar">
                        <?php if ($profile_photo): ?>
                            <img src="assets/uploads/<?= htmlspecialchars($profile_photo) ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        <?php else: ?>
                            👤
                        <?php endif; ?>
                    </div>
                    <div class="mitra-profile-info">
                        <p class="mitra-profile-name"><?= htmlspecialchars($user['username'] ?? 'Mitra') ?></p>
                        <p class="mitra-profile-link"><?= htmlspecialchars($user['email'] ?? 'email@domain.com') ?></p>
                        <p style="font-size: 13px; color: rgba(255,255,255,0.8); margin-top: 8px; max-width: 320px;">
                            <?= htmlspecialchars($profile_bio ?: 'Tambahkan bio kamu di profil agar pengguna lebih mengenalmu.') ?>
                        </p>
                    </div>
                    <a href="profile.php" class="mitra-btn-share">Edit Profil</a>
                </div>

                <div class="mitra-actions-scroll">
                    <button class="mitra-action-btn" onclick="openDigitalProductModal()">Digital Product</button>
                    <button class="mitra-action-btn" onclick="openCourseModal()">Course Video</button>
                    <a href="setup.php" class="mitra-action-btn">Set up</a>
</div> <div>
                    <h3 class="my-products-title">My Links & Products</h3>

    <?php while($row = mysqli_fetch_assoc($query_products)) { ?>
<div class="product-list-card" style="display: flex; align-items: center; gap: 15px;">
    
    <div class="plc-image">
        <?php if (!empty($row['image'])): ?>
            <img src="assets/uploads/<?= htmlspecialchars($row['image']) ?>" 
                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
        <?php else: ?>
            <img src="assets/lucu.jpg" 
                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
        <?php endif; ?>
    </div>

    <div class="plc-info" style="flex: 1;">
        <div class="plc-title" style="font-weight: bold;"><?= htmlspecialchars($row['name']) ?></div>
        <div>
            <span class="plc-category" style="font-size: 12px; color: #666;"><?= ucfirst($row['category']) ?></span>
            <span class="plc-price" style="font-size: 14px; color: #4f1d70; font-weight: bold; margin-left: 10px;">
                Rp <?= number_format($row['price'], 0, ',', '.') ?>
            </span>
        </div>
    </div>
    
    <div class="plc-actions">
        <button class="plc-btn-edit" 
        onclick="openEditModal('<?= $row['id'] ?>', '<?= addslashes($row['name']) ?>', '<?= $row['price'] ?>', '<?= addslashes($row['description']) ?>', '<?= $row['category'] ?>')">
    Edit
</button>
        <a href="proses_delete.php?id=<?= $row['id'] ?>" class="plc-btn-delete" onclick="return confirm('Hapus produk ini?')">Delete</a>
    </div>
</div>
<?php } ?>

    <!-- Products Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination-container">
            <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <?php if ($page <= 1): ?>
                        <span>&lsaquo;</span>
                    <?php else: ?>
                        <a class="page-link" href="?page=<?= $page - 1 ?>">&lsaquo;</a>
                    <?php endif; ?>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <?php if ($page >= $totalPages): ?>
                        <span>&rsaquo;</span>
                    <?php else: ?>
                        <a class="page-link" href="?page=<?= $page + 1 ?>">&rsaquo;</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    <?php endif; ?>
    </div>
    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="mitra-modal-overlay" id="digitalModal">
        <div class="mitra-modal-container">
            
            <div class="mitra-modal-header">
                <h2>Add Digital Product</h2>
                <button class="mitra-close-btn" onclick="closeDigitalProductModal()">&times;</button>
            </div>

            <form action="proses_simpan.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                
                <div class="mitra-form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="mitra-input" placeholder="Masukkan judul produk" required>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="mitra-form-group" style="flex: 1;">
                        <label>Price</label>
                        <input type="number" id="price" name="price" class="mitra-input" required>
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

                <button type="submit" class="mitra-submit-btn">Add Digital</button>
                <div style="clear: both;"></div>
            </form>

        </div>
    </div>
    <div class="mitra-modal-overlay" id="courseModal">
        <div class="mitra-modal-container">
            <div class="mitra-modal-header">
                <h2 style="text-transform: uppercase; font-size: 18px; color: #888;">Add Course Video</h2>
                <button class="mitra-close-btn" onclick="closeCourseModal()">&times;</button>
            </div>

            <form action="proses_course.php" method="POST" enctype="multipart/form-data">
                
                <div class="mitra-form-group">
                    <label style="text-transform: uppercase; font-size: 12px;">Video Title</label>
                    <input type="text" name="video_title" class="mitra-input" placeholder="Contoh: Mastering Digital Curation: Phase 1" required>
                </div>

                <div class="mitra-form-group">
                    <label style="text-transform: uppercase; font-size: 12px;">Description</label>
                    <textarea name="description" class="mitra-input" rows="4" placeholder="In this module, we explore the principles..."></textarea>
                </div>

                <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <div class="mitra-form-group" style="flex: 1;">
                        <label style="text-transform: uppercase; font-size: 12px;">Video Source</label>
                        <div class="mitra-tabs">
                            <button type="button" class="mitra-tab active" id="tabUrl" onclick="switchTab('url')">🔗 URL</button>
                            <button type="button" class="mitra-tab" id="tabUpload" onclick="switchTab('upload')">📤 Upload</button>
                        </div>
                        <input type="text" id="inputUrl" name="video_url" class="mitra-input" placeholder="Paste YouTube, Vimeo or Loom">
                        <input type="file" id="inputUpload" name="video_file" class="mitra-input" style="display: none;">
                    </div>

                    <div class="mitra-form-group" style="flex: 1;">
                        <label style="text-transform: uppercase; font-size: 12px;">Course Cover</label>
                        <div class="mitra-upload-box" onclick="document.getElementById('courseCover').click()">
                            <span style="font-size: 24px;">🖼️</span>
                            <span style="font-size: 12px; margin-top: 5px; font-weight: bold;">Replace Thumbnail</span>
                        </div>
                        <input type="file" id="courseCover" name="course_cover" style="display: none;">
                    </div>
                </div>

                <button type="submit" class="mitra-submit-btn" style="background-color: #4f1d70; width: 100%; float: none;">Add Course Video</button>
            </form>
        </div>
    </div>
    <div class="mitra-modal-overlay" id="editModal">
    <div class="mitra-modal-container">
        <div class="mitra-modal-header">
            <h2>Edit Product / Service</h2>
            <button class="mitra-close-btn" onclick="closeEditModal()">&times;</button>
        </div>

        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="edit_id" name="id">

            <div class="mitra-form-group">
                <label>Name / Title</label>
                <input type="text" id="edit_name" name="name" class="mitra-input" required>
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="mitra-form-group" style="flex: 1;">
                    <label>Price (IDR)</label>
                    <input type="number" id="edit_price" name="price" class="mitra-input" max="1000000" required>
                </div>
                <div class="mitra-form-group" style="flex: 1;">
                    <label>Category</label>
                    <select id="edit_category" name="category" class="mitra-input">
                        <option value="digital">Digital Product</option>
                        <option value="course">Course Video</option>
                        <option value="setup">Set up</option>
                    </select>
                </div>
            </div>

            <div class="mitra-form-group">
                <label>Description</label>
                <textarea id="edit_description" name="description" class="mitra-input" rows="4"></textarea>
            </div>

            <div class="mitra-form-group">
                <label>Update Image (Kosongkan jika tidak diganti)</label>
                <input type="file" name="gambar" class="mitra-input">
            </div>

            <button type="submit" class="mitra-submit-btn" style="width: 100%; float: none; background-color: #4f1d70;">
                Update Data
            </button>
        </form>
    </div>
</div>
    <script>
        // Fungsi untuk membuka Modal
        function openDigitalProductModal() {
            document.getElementById('digitalModal').classList.add('active');
        }

        // Fungsi untuk menutup Modal
        function closeDigitalProductModal() {
            document.getElementById('digitalModal').classList.remove('active');
        }

        // Opsional: Tutup modal kalau user klik area hitam (overlay) di luar form
        document.getElementById('digitalModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDigitalProductModal();
            }
        });

        // Validasi Form (Syarat interaktivitas JS untuk ETS)
        function validateForm() {
            var price = document.getElementById("price").value;
            if (price <= 0) {
                alert("Harga produk tidak boleh bernilai kurang/sama dengan 0!");
                return false;
            }
            if (price > 1000000) {
                alert("Harga produk tidak boleh bernilai lebih 1000000!");
                return false;
            }
        }
        // Fungsi Buka Tutup Modal Course
        function openCourseModal() {
            document.getElementById('courseModal').classList.add('active');
        }

        function closeCourseModal() {
            document.getElementById('courseModal').classList.remove('active');
        }

        // Tutup modal Course jika klik area luar
        document.getElementById('courseModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCourseModal();
            }
        });

        // Interaktivitas Tab (Syarat JS ETS)
        function switchTab(type) {
            var tabUrl = document.getElementById('tabUrl');
            var tabUpload = document.getElementById('tabUpload');
            var inputUrl = document.getElementById('inputUrl');
            var inputUpload = document.getElementById('inputUpload');

            if (type === 'url') {
                tabUrl.classList.add('active');
                tabUpload.classList.remove('active');
                inputUrl.style.display = 'block';
                inputUpload.style.display = 'none';
            } else {
                tabUpload.classList.add('active');
                tabUrl.classList.remove('active');
                inputUrl.style.display = 'none';
                inputUpload.style.display = 'block';
            }
        }   
        function openUpgradeModal() {
            document.getElementById('upgradeModal').classList.add('active');
        }

        function closeUpgradeModal() {
            document.getElementById('upgradeModal').classList.remove('active');
        }

        function selectPayment(element) {
            // Hapus seleksi dari semua opsi
            const options = document.querySelectorAll('.payment-option');
            options.forEach(opt => opt.classList.remove('selected'));
            
            // Tambahkan seleksi ke yang diklik
            element.classList.add('selected');
        }

        // Tutup modal jika klik luar area
        document.getElementById('upgradeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUpgradeModal();
            }
        });
        function openEditModal(id, name, price, desc, category) {
    // Masukkan data ke dalam form modal edit
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_description').value = desc;
    document.getElementById('edit_category').value = category;

    // Tampilkan modal
    document.getElementById('editModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('remove');
    document.getElementById('editModal').classList.remove('active');
}

// Tutup modal edit jika klik luar area
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
    </script>
<div class="mitra-modal-overlay" id="upgradeModal">
        <div class="mitra-modal-container" style="max-width: 500px;"> <div class="mitra-modal-header">
                <h2>Upgrade to Pro</h2>
                <button class="mitra-close-btn" onclick="closeUpgradeModal()">&times;</button>
            </div>

            <div class="pro-modal-content">
                <div class="pro-badge">BEST VALUE</div>
                <p style="color: #666; margin: 0;">Nikmati semua fitur tanpa batas di</p>
                <h3 style="margin: 5px 0; color: #4f1d70;">RAYA STUDIO PRO</h3>
                
                <div class="pro-price-tag">Rp 99.000 <span style="font-size: 14px; font-weight: normal; color: #888;">/bulan</span></div>

                <ul class="pro-features-list">
                    <li>Komisi Penjualan 0% (Full buat kamu)</li>
                    <li>Custom URL (lynk.id/nama-kamu)</li>
                    <li>Upload Video Kursus tanpa batas</li>
                    <li>Prioritas di daftar pencarian teknisi</li>
                    <li>Analistik pengunjung yang lebih detail</li>
                </ul>

                <h4 style="text-align: left; font-size: 14px; color: #333;">Pilih Metode Pembayaran:</h4>
                <div class="payment-methods">
                    <div class="payment-option" onclick="selectPayment(this)">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/1200px-QRIS_logo.svg.png" alt="QRIS">
                    </div>
                </div>

                <form action="proses_upgrade.php" method="POST">
                    <input type="hidden" name="plan" value="pro">
                    <button type="submit" class="mitra-submit-btn" style="width: 100%; float: none; margin-top: 25px; background: linear-gradient(45deg, #4f1d70, #855799);">
                        Bayar Sekarang
                    </button>
                </form>
    <!-- Logout Overlay -->
    <div id="logoutOverlay" class="logout-overlay">
        <div class="logout-box">
            <div class="logout-spinner"></div>
            <h3>Logging Out</h3>
            <p>Leaving the space, please wait...</p>
        </div>
    </div>

    <script>
    function triggerLogout(event) {
        event.preventDefault();
        if (confirm("Apakah Anda yakin ingin logout?")) {
            var overlay = document.getElementById('logoutOverlay');
            if (overlay) {
                overlay.classList.add('visible');
            }
            setTimeout(function() {
                window.location.href = 'logout.php';
            }, 1200);
        }
    }
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function initSlidingPill(containerSelector, itemSelector) {
        const containers = document.querySelectorAll(containerSelector);
        containers.forEach(container => {
            const computedStyle = window.getComputedStyle(container);
            if (computedStyle.position === 'static') {
                container.style.position = 'relative';
            }

            let pill = container.querySelector('.sliding-pill-indicator');
            if (!pill) {
                pill = document.createElement('div');
                pill.className = 'sliding-pill-indicator';
                container.appendChild(pill);
            }

            const items = container.querySelectorAll(itemSelector);
            
            function updatePill(target) {
                if (!target) {
                    pill.style.opacity = '0';
                    return;
                }
                pill.style.opacity = '1';
                
                const containerRect = container.getBoundingClientRect();
                const targetRect = target.getBoundingClientRect();
                
                const left = targetRect.left - containerRect.left + container.scrollLeft;
                const top = targetRect.top - containerRect.top + container.scrollTop;
                
                pill.style.left = left + 'px';
                pill.style.width = targetRect.width + 'px';
                pill.style.top = top + 'px';
                pill.style.height = targetRect.height + 'px';
                
                const targetStyle = window.getComputedStyle(target);
                pill.style.borderRadius = targetStyle.borderRadius;
            }

            function getActive() {
                return container.querySelector(itemSelector + '.active') || container.querySelector('li.active');
            }

            // Initial positioning
            setTimeout(() => {
                updatePill(getActive());
            }, 200);

            items.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    updatePill(item);
                });
            });

            container.addEventListener('mouseleave', () => {
                updatePill(getActive());
            });

            window.addEventListener('resize', () => {
                updatePill(getActive());
            });

            // Handle dynamically updated active states (e.g. scrollspy or tab clicks)
            const observer = new MutationObserver(() => {
                updatePill(getActive());
            });
            observer.observe(container, { attributes: true, subtree: true, attributeFilter: ['class'] });
        });
    }

    initSlidingPill('.navbar .menu', 'a, button');
    initSlidingPill('.tabs-container', '.tab-btn');
    initSlidingPill('.mitra-nav-list', 'li, a');
    initSlidingPill('.menu', 'a');
    initSlidingPill('.filter-container', '.filter-chip');
});
</script>

</body>
</html>