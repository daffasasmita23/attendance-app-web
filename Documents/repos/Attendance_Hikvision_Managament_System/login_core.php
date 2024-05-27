<?php
session_start();

include_once "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    echo mysqli_error($connection);
    throw new Exception("Database cannot Connect");
}
$action = $_REQUEST['action'] ?? '';

if ('login' == $action) {
    $username = $_REQUEST['username'] ?? '';
    $password = $_REQUEST['password'] ?? '';

    if ($username && $password) {
        // Escape the inputs to prevent SQL injection
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);

        // Create the SQL query
        $query = "SELECT * FROM users WHERE username='{$username}'";
        $result = mysqli_query($connection, $query);

        if ($data = mysqli_fetch_assoc($result)) {
            $_password = $data['password'] ?? '';
            $_username = $data['username'] ?? '';
            $_id = $data['id'] ?? '';
            $_role = $data['role'] ?? '';

            if (password_verify($password, $_password)) {
                $_SESSION['role'] = $_role;
                $_SESSION['id'] = $_id;
                header("location:index.php");
                die();
            } else {
                $_SESSION['error'] = "Incorrect password";
                header("location:login.php?error");
            }
        } else {
            header("location:login.php?error");
        }
    }
}