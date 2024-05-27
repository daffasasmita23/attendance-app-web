<?php
// Koneksi ke database
$connection = new mysqli('localhost:3307', 'root', '', 'pms');

// Cek koneksi
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Ambil role dari POST data
$roleName = $_POST['roleName'];

// Cek apakah role ada dalam database
$checkSql = "SELECT * FROM users WHERE role = ?";
$checkStmt = $connection->prepare($checkSql);
$checkStmt->bind_param('s', $roleName);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows == 0) {
    echo "Role tidak ada";
    $checkStmt->close();
    $connection->close();
    exit();
}

$checkStmt->close();

// Query untuk menghapus role
$sql = "DELETE FROM users WHERE role = ?";

// Prepare statement
$stmt = $connection->prepare($sql);
if ($stmt === false) {
    die("Error: " . $connection->error);
}

// Bind parameters
$stmt->bind_param('s', $roleName);

// Eksekusi query
if ($stmt->execute()) {
    echo "Role deleted successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$connection->close();
?>