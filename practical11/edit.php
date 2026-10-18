
<?php
include 'db.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$msg = "";

$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) die("Student not found!");

if (isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $roll = trim($_POST['roll_no']);
    $email = trim($_POST['email']);
    $course = $_POST['course'];

    if ($name && $roll && filter_var($email, FILTER_VALIDATE_EMAIL)
        && in_array($course, ['CSE','IT','CE'])) {

        $stmt = $conn->prepare(
            "UPDATE students SET name=?,roll_no=?,email=?,course=? WHERE id=?"
        );
        $stmt->bind_param("ssssi", $name, $roll, $email, $course, $id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $msg = "Update Failed!";
        }
    } else {
        $msg = "Please enter valid details!";
    }
}
?>

<h2>Edit Student</h2>
<p><?php echo htmlspecialchars($msg); ?></p>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <input name="name" required
      value="<?php echo htmlspecialchars($_POST['name'] ?? $student['name']); ?>">

    <input name="roll_no" required
      value="<?php echo htmlspecialchars($_POST['roll_no'] ?? $student['roll_no']); ?>">

    <input type="email" name="email" required
      value="<?php echo htmlspecialchars($_POST['email'] ?? $student['email']); ?>">

    <select name="course" required>
        <?php foreach (['CSE','IT','CE'] as $c) { ?>
        <option value="<?php echo $c; ?>"
          <?php echo (($_POST['course'] ?? $student['course']) === $c) ? 'selected' : ''; ?>>
          <?php echo $c; ?>
        </option>
        <?php } ?>
    </select>

    <button name="update">Update Student</button>
</form>

<a href="index.php">Back</a>
