<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "database.php";

$user_id = $_SESSION['user_id'];
$user = null;
$profile_photo = $_SESSION['profile_photo'] ?? '';
$profile_bio = $_SESSION['profile_bio'] ?? '';
$profile_birth_place = $_SESSION['profile_birth_place'] ?? '';
$profile_birth_date = $_SESSION['profile_birth_date'] ?? '';

$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
if ($user_query) {
    $user = mysqli_fetch_assoc($user_query);
}

$success = isset($_GET['success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Raya Studio</title>
    <link rel="stylesheet" href="style.css?v=10">
    <style>
        body { background: #f3f7f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background: white; box-shadow: 0 4px 14px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 10; }
        .navbar h2 { margin: 0; color: #4f1d70; }
        .navbar .menu a { margin-left: 18px; text-decoration: none; color: #555; padding: 10px 14px; border-radius: 12px; transition: 0.2s; }
        .navbar .menu a:hover, .navbar .menu a.active { background: #4f1d70; color: white; }
        .profile-page { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .profile-card { display: grid; grid-template-columns: 150px 1fr; gap: 30px; background: white; padding: 30px; border-radius: 24px; box-shadow: 0 14px 30px rgba(0,0,0,0.08); animation: fadeInUp 0.5s ease both; }
        .profile-image { width: 150px; height: 150px; border-radius: 24px; overflow: hidden; background: #f3e8ff; display: flex; align-items: center; justify-content: center; }
        .profile-image img { width: 100%; height: 100%; object-fit: cover; }
        .profile-details h1 { margin: 0 0 10px; color: #2c0f4e; }
        .profile-details p { margin: 8px 0; color: #555; line-height: 1.5; }
        .profile-meta { margin-top: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; }
        .profile-meta div { background: #f7f0ff; border-radius: 16px; padding: 16px; color: #4f1d70; }
        .profile-form { margin-top: 30px; background: white; border-radius: 24px; padding: 30px; box-shadow: 0 14px 30px rgba(0,0,0,0.08); }
        .profile-form h2 { margin-top: 0; color: #4f1d70; }
        .form-group { margin-bottom: 22px; }
        .form-group label { display: block; margin-bottom: 10px; color: #333; font-weight: 600; }
        .form-group input, .form-group textarea { width: 100%; padding: 14px 16px; border-radius: 14px; border: 1px solid #ddd; font-size: 14px; }
        .form-group textarea { min-height: 130px; resize: vertical; }
        .form-note { color: #777; font-size: 13px; margin-top: 6px; }
        .btn-save { background: #6a0dad; color: white; border: none; padding: 14px 26px; border-radius: 18px; cursor: pointer; font-size: 15px; transition: 0.25s; }
        .btn-save:hover { background: #4f1d70; }
        .success-message { background: #e3f8e6; border: 1px solid #aee2c6; padding: 16px 20px; border-radius: 16px; color: #22543d; margin-bottom: 20px; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #4f1d70; text-decoration: none; font-weight: 600; }
        @media (max-width: 768px) {
            .navbar { flex-direction: column; gap: 15px; padding: 15px; text-align: center; }
            .navbar .menu { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; }
            .navbar .menu a { margin: 0; }
            .profile-card { grid-template-columns: 1fr; }
            .profile-meta { grid-template-columns: 1fr; }
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
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Profil Saya</h2>
        <div class="menu">
            <a href="dashboard_customer.php">Dashboard</a>
            <a href="mitra.php">Mitra</a>
            <a href="profile.php" class="active">Profil</a>
            <a href="logout.php" onclick="triggerLogout(event)">Logout</a>
        </div>
    </div>

    <div class="profile-page">
        <?php if ($success): ?>
            <div class="success-message">Profil berhasil diperbarui.</div>
        <?php endif; ?>

        <a href="dashboard_customer.php" class="back-link">← Kembali ke Dashboard</a>

        <div class="profile-card">
            <div class="profile-image">
                <?php if ($profile_photo): ?>
                    <img src="assets/uploads/<?= htmlspecialchars($profile_photo) ?>" alt="Foto Profil">
                <?php else: ?>
                    <span style="font-size: 64px; color: #9d4edd;">👤</span>
                <?php endif; ?>
            </div>
            <div class="profile-details">
                <h1><?= htmlspecialchars($user['username'] ?? 'Nama Pengguna') ?></h1>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'email@domain.com') ?></p>
                <p><strong>Peran:</strong> <?= htmlspecialchars(ucfirst($user['role'] ?? 'customer')) ?></p>
                <p><?= htmlspecialchars($profile_bio ?: 'Tambahkan bio singkat agar orang tahu lebih banyak tentangmu.') ?></p>
                <div class="profile-meta">
                    <div><strong>Tempat Lahir</strong><br><?= htmlspecialchars($profile_birth_place ?: 'Belum diisi') ?></div>
                    <div><strong>Tanggal Lahir</strong><br><?= htmlspecialchars($profile_birth_date ?: 'Belum diisi') ?></div>
                </div>
            </div>
        </div>

        <form action="proses_profile.php" method="POST" enctype="multipart/form-data" class="profile-form">
            <h2>Edit Profil</h2>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" placeholder="Contoh: Saya creator konten live streaming..."><?= htmlspecialchars($profile_bio) ?></textarea>
                <p class="form-note">Boleh dikosongkan jika belum ingin menulis.</p>
            </div>

            <div class="form-group">
                <label for="birth_place">Tempat Lahir</label>
                <input type="text" id="birth_place" name="birth_place" value="<?= htmlspecialchars($profile_birth_place) ?>" placeholder="Contoh: Surabaya">
            </div>

            <div class="form-group">
                <label for="birth_date">Tanggal Lahir</label>
                <input type="date" id="birth_date" name="birth_date" value="<?= htmlspecialchars($profile_birth_date) ?>">
            </div>

            <div class="form-group">
                <label for="profile_photo">Foto Profil</label>
                <input type="file" id="profile_photo" name="profile_photo">
                <p class="form-note">Unggah foto profil jika ingin mengganti avatar.</p>
            </div>

            <button type="submit" class="btn-save">Simpan Profil</button>
        </form>
    </div>
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
</body>
</html>
