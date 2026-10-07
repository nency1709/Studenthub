<?php

$conn = new mysqli("localhost", "root", "", "user_registration");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>