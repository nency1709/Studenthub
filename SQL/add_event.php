<?php

include "db.php";

$event_name = "AI Workshop";
$event_date = "2026-12-01";
$venue = "Seminar Hall";

$sql = "INSERT INTO events (event_name, event_date, venue)
        VALUES (?, ?, ?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $event_name,
    $event_date,
    $venue
]);

echo "Event Added Successfully";

?>