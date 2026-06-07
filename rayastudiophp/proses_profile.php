<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "database.php";

$user_id = $_SESSION['user_id'];
$bio = $_POST['bio'] ?? '';
$birth_place = $_POST['birth_place'] ?? '';
$birth_date = $_POST['birth_date'] ?? '';

$_SESSION['profile_bio'] = trim($bio);
$_SESSION['profile_birth_place'] = trim($birth_place);
$_SESSION['profile_birth_date'] = trim($birth_date);

if (!empty($_FILES['profile_photo']['name'])) {
    $filename = basename($_FILES['profile_photo']['name']);
    $filename = preg_replace('/[^A-Za-z0-9._-]/', '_', $filename);
    $uploadPath = __DIR__ . '/assets/uploads/' . $filename;

    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadPath)) {
        $_SESSION['profile_photo'] = $filename;
    }
}

header('Location: profile.php?success=1');
exit;
