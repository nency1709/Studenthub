```php
<?php
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Management</title>
</head>
<body>

<h2>Event Management System</h2>

<a href="add_event.php">Add New Event</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Description</th>
        <th>Poster</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>

        <td>
            <?php echo htmlspecialchars($row['event_name']); ?>
        </td>

        <td><?php echo $row['event_date']; ?></td>

        <td>
            <?php echo htmlspecialchars($row['description'] ?? ''); ?>
        </td>

        <td>
            <?php if ($row['poster'] && is_file('uploads/' . $row['poster'])) { ?>
                <img src="uploads/<?php echo rawurlencode($row['poster']); ?>"
                     width="100" alt="Event poster">
            <?php } ?>
        </td>

        <td>
            <a href="edit_event.php?id=<?php echo $row['id']; ?>">
                Edit
            </a>

            |

            <a href="delete_event.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Delete this event?')">
                Delete
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
```