<?php

include "db.php";

$name = "Jay";
$email = "jay@gmail.com";
$phone = "9876543210";

$sql = "INSERT INTO students (name, email, phone)
        VALUES (?, ?, ?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $name,
    $email,
    $phone
]);

echo "Student Added Successfully";

?>