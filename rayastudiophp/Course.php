<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course Video - Raya Studio</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f3f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .form-card {
            background: white;
            width: 100%;
            max-width: 700px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .label-title {
            font-size: 12px;
            font-weight: bold;
            color: #83529b;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        .form-group { margin-bottom: 25px; }

        input[type="text"], textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 10px;
            background-color: #fff;
            font-size: 15px;
            outline: none;
        }

        /* Layout dua kolom untuk bagian bawah */
        .bottom-row {
            display: flex;
            gap: 30px;
        }

        .col-left, .col-right { flex: 1; }

        /* Styling Video Source */
        .source-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .tab-btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn.active { background-color: #521475; color: white; }
        .tab-btn.upload { background-color: #f0e6f5; color: #521475; }

        .url-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .url-input-container input {
            padding-left: 45px; /* Kasih ruang buat icon */
        }

        /* Styling Course Cover (Upload Box) */
        .cover-upload-box {
            width: 100%;
            height: 160px;
            border: 2px dashed #ddd;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background-color: #fafafa;
            color: #83529b;
            transition: 0.3s;
        }

        .cover-upload-box:hover { border-color: #83529b; background-color: #f9f4fb; }

        .btn-save {
            background-color: #521475;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 30px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="form-card">
    <form action="proses_course.php" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
            <label class="label-title">Video Title</label>
            <input type="text" name="video_title" placeholder="Contoh: Mastering Digital Curation: Phase 1">
        </div>

        <div class="form-group">
            <label class="label-title">Description</label>
            <textarea name="description" rows="5" placeholder="In this module, we explore the principles..."></textarea>
        </div>

        <div class="bottom-row">
            <div class="col-left">
                <label class="label-title">Video Source</label>
                <div class="source-tabs">
                    <button type="button" class="tab-btn active">🔗 URL</button>
                    <button type="button" class="tab-btn upload">📤 Upload</button>
                </div>
                <div class="url-input-container">
                    <input type="text" name="video_url" placeholder="Paste YouTube, Vimeo or Loom">
                </div>
            </div>

            <div class="col-right">
                <label class="label-title">Course Cover</label>
                <div class="cover-upload-box" onclick="document.getElementById('coverInput').click()">
                    <span style="font-size: 24px; margin-bottom: 5px;">🖼️</span>
                    <span style="font-size: 13px; font-weight: 600;">Replace Thumbnail</span>
                    <input type="file" id="coverInput" name="course_cover" hidden>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-save">Add Course Video</button>
        <a href="mitra.php" style="display:block; text-align:center; margin-top:15px; color:#888; text-decoration:none; font-size:14px;">Cancel</a>
    </form>
</div>

</body>
</html>
<style>
    /* --- CSS KHUSUS HALAMAN ADD COURSE VIDEO --- */

/* Reset dasar agar tidak berantakan */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}

body {
    background-color: #f3f7f7;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

/* Kartu Utama di Tengah */
.form-card {
    background: white;
    width: 100%;
    max-width: 700px; /* Lebar ideal untuk form di tengah */
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* Label ungu kecil di atas input (seperti referensi) */
.label-title {
    font-size: 11px;
    font-weight: 800;
    color: #83529b; /* Ungu sedang */
    text-transform: uppercase;
    margin-bottom: 8px;
    display: block;
    letter-spacing: 0.5px;
}

.form-group {
    margin-bottom: 25px;
}

/* Styling Input & Textarea */
input[type="text"], 
textarea {
    width: 100%;
    padding: 15px;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    background-color: #fafafa;
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}

input:focus, textarea:focus {
    border-color: #83529b;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(131, 82, 155, 0.05);
}

/* Layout Baris Bawah (Dua Kolom) */
.bottom-row {
    display: flex;
    gap: 30px;
}

.col-left, .col-right {
    flex: 1;
}

/* Video Source Tabs */
.source-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 12px;
}

.tab-btn {
    padding: 8px 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 700;
    font-size: 13px;
    transition: 0.3s;
}

.tab-btn.active {
    background-color: #2b0b3d; /* Ungu gelap banget (URL aktif) */
    color: white;
}

.tab-btn.upload {
    background-color: #f5f0f8; /* Ungu pudar */
    color: #83529b;
}

/* Course Cover / Thumbnail Box */
.cover-upload-box {
    width: 100%;
    height: 160px;
    border: 2px dashed #e0e0e0;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background-color: #fcfcfc;
    color: #83529b;
    transition: 0.3s;
}

.cover-upload-box:hover {
    border-color: #83529b;
    background-color: #f9f6fb;
}

/* Tombol Save Utama */
.btn-save {
    background-color: #521475; /* Ungu Raya Studio */
    color: white;
    border: none;
    padding: 18px;
    border-radius: 35px;
    font-weight: 700;
    cursor: pointer;
    width: 100%;
    margin-top: 20px;
    font-size: 16px;
    transition: transform 0.2s, background 0.3s;
}

.btn-save:hover {
    background-color: #3d0f57;
    transform: translateY(-2px);
}
</style>