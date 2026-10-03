<?php

include "db.php";

$student_id = 4;
$event_id = 4;

$sql = "INSERT INTO registrations (student_id, event_id)
        VALUES (?, ?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $student_id,
    $event_id
]);

echo "Registration Successful";

?>