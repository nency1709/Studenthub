<?php
$conn = mysqli_connect("localhost", "root", "", "admin_db");

if (!$conn) {
    die("Database connection failed");
}

mysqli_set_charset($conn, "utf8mb4");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>