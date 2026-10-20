```php
<?php
include 'db.php';

$msg = "";

if (isset($_POST['submit'])) {
    $name = trim($_POST['event_name']);
    $date = $_POST['event_date'];
    $desc = trim($_POST['description']);

    if ($name == "" || $date == "") {
        $msg = "Please fill required fields!";
    } elseif (!isset($_FILES['poster']) ||
              $_FILES['poster']['error'] != 0) {
        $msg = "Please upload a valid poster!";
    } else {
        $file = $_FILES['poster'];
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo(
            $file['name'], PATHINFO_EXTENSION
        ));

        $imageInfo = @getimagesize($file['tmp_name']);

        if ($file['size'] > 2 * 1024 * 1024) {
            $msg = "Poster must be under 2 MB!";
        } elseif (!in_array($ext, $allowed) ||
                  !$imageInfo ||
                  !in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG])) {
            $msg = "Only JPG, JPEG and PNG images allowed!";
        } else {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            $poster = uniqid('poster_', true) . '.' . $ext;
            $path = 'uploads/' . $poster;

            if (move_uploaded_file($file['tmp_name'], $path)) {
                $stmt = mysqli_prepare(
                    $conn,
                    "INSERT INTO events
                    (event_name, event_date, description, poster)
                    VALUES (?, ?, ?, ?)"
                );

                mysqli_stmt_bind_param(
                    $stmt, "ssss", $name, $date, $desc, $poster
                );

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php");
                    exit;
                } else {
                    unlink($path);
                    $msg = "Event could not be saved!";
                }
            } else {
                $msg = "Poster upload failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
</head>
<body>

<h2>Add New Event</h2>

<p><?php echo htmlspecialchars($msg); ?></p>

<form method="POST" enctype="multipart/form-data">

    Event Name:
    <input type="text" name="event_name" required>
    <br><br>

    Event Date:
    <input type="date" name="event_date" required>
    <br><br>

    Description:
    <textarea name="description"></textarea>
    <br><br>

    Event Poster:
    <input type="file" name="poster"
           accept=".jpg,.jpeg,.png" required>
    <br>
    <small>Only JPG, JPEG, PNG. Maximum size: 2 MB.</small>
    <br><br>

    <button type="submit" name="submit">Add Event</button>

</form>

<br>
<a href="index.php">View Events</a>

</body>
</html>
```