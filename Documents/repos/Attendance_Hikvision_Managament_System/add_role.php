<?php
// Koneksi ke database
$connection = mysqli_connect("localhost:3307", "root", "", "pms");

// Cek koneksi
if ($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Ambil data dari form
$roleName = $_POST['role_name'];

// Cek apakah role sudah ada
$checkSql = "SELECT * FROM permissions WHERE role = ?";
$checkStmt = mysqli_prepare($connection, $checkSql);
mysqli_stmt_bind_param($checkStmt, 's', $roleName);
mysqli_stmt_execute($checkStmt);
$result = mysqli_stmt_get_result($checkStmt);

if(mysqli_num_rows($result) > 0){
    echo "<script>alert('Role Already Exists.');window.location.href=document.referrer;</script>";
} else {
    // Query untuk insert data
    $sql = "INSERT INTO permissions (role) VALUES (?)";

    // Membuat prepared statement
    $stmt = mysqli_prepare($connection, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 's', $roleName);

    // Eksekusi query

    if(mysqli_stmt_execute($stmt)){
        echo "<script>alert('Records inserted successfully.');window.location.href=document.referrer;</script>";
    } else{
        echo "<script>alert('ERROR: Could not execute query: $sql. " . mysqli_error($connection) . "');window.location.href=document.referrer;</script>";
    }
    

    // Tutup statement
    mysqli_stmt_close($stmt);
}

// Tutup statement cek
mysqli_stmt_close($checkStmt);

// Tutup koneksi
mysqli_close($connection);
?>