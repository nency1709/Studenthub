
<?php
include 'db.php';
$msg = "";

if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $roll = trim($_POST['roll_no']);
    $email = trim($_POST['email']);
    $course = $_POST['course'];

    if ($name && $roll && filter_var($email, FILTER_VALIDATE_EMAIL) && $course) {
        $stmt = $conn->prepare(
            "INSERT INTO students(name,roll_no,email,course) VALUES(?,?,?,?)"
        );
        $stmt->bind_param("ssss", $name, $roll, $email, $course);
        $msg = $stmt->execute() ? "Student Added Successfully!" : "Add Failed!";
    } else {
        $msg = "Please enter valid details!";
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $msg = $stmt->execute() && $stmt->affected_rows
        ? "Student Deleted Successfully!" : "Delete Failed!";
}

$search = trim($_GET['search'] ?? '');
$course = $_GET['course'] ?? '';

$sql = "SELECT * FROM students WHERE name LIKE CONCAT('%',?,'%')";
if ($course !== '') $sql .= " AND course=?";
$stmt = $conn->prepare($sql);

if ($course !== '') {
    $stmt->bind_param("ss", $search, $course);
} else {
    $stmt->bind_param("s", $search);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
</head>
<body>
<h2>Student Management System</h2>

<p><?php echo htmlspecialchars($msg); ?></p>

<form method="post">
    <input name="name" placeholder="Student Name" required>
    <input name="roll_no" placeholder="Roll No" required>
    <input type="email" name="email" placeholder="Email" required>

    <select name="course" required>
        <option value="">Select Course</option>
        <option value="CSE">CSE</option>
        <option value="IT">IT</option>
        <option value="CE">CE</option>
    </select>
    <button name="add">Add Student</button>
</form>

<hr>

<form method="get">
    <input name="search" placeholder="Search by Name"
           value="<?php echo htmlspecialchars($search); ?>">
    <select name="course">
        <option value="">All Courses</option>
        <option value="CSE">CSE</option>
        <option value="IT">IT</option>
        <option value="CE">CE</option>
    </select>
    <button>Search / Filter</button>
    <a href="index.php">Reset</a>
</form>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th><th>Name</th><th>Roll No</th>
    <th>Email</th><th>Course</th><th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['name']); ?></td>
    <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
    <td><?php echo htmlspecialchars($row['email']); ?></td>
    <td><?php echo htmlspecialchars($row['course']); ?></td>
    <td>
        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a href="index.php?delete=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this student?')">Delete</a>
    </td>
</tr>
<?php } ?>

<?php if ($result->num_rows == 0) { ?>
<tr><td colspan="6">No Student Found!</td></tr>
<?php } ?>
</table>
</body>
</html>
