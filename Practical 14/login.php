<?php
include 'db.php';

$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, name, email, password, role
         FROM users WHERE email = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user &&
        hash_equals($user['password'], hash('sha256', $password))) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
           $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO audit_logs (user_id, action)
         VALUES (?, ?)"
    );

    $action = "Admin logged in";

    mysqli_stmt_bind_param(
        $stmt,
        "is",
        $_SESSION['user_id'],
        $action
    );

    mysqli_stmt_execute($stmt);

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box">

    <h2>Admin Login</h2>

    <p class="error">
        <?php echo htmlspecialchars($error); ?>
    </p>

    <form method="POST">

        <input
            type="email"
            name="email"
            placeholder="Enter Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Enter Password"
            required
        >

        <button type="submit" name="login">
            Login
        </button>

    </form>

</div>

</body>
</html>