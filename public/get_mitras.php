<?php
try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=raya_db', 'root', '');
    $stmt = $db->query("SELECT id, username FROM users WHERE role = 'mitra'");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
