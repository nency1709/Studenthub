```php
<?php
include 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid event ID");
}

$stmt = mysqli_prepare($conn, "SELECT poster FROM events WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$row) {
    die("Event not found");
}

$stmt = mysqli_prepare($conn, "DELETE FROM events WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    if ($row['poster'] && is_file('uploads/' . $row['poster'])) {
        unlink('uploads/' . $row['poster']);
    }

    header("Location: index.php");
    exit;
}

echo "Delete failed!";
?>
```