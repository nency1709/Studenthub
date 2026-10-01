<?php

if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Validation
    if ($name == "" || $email == "" || $phone == "") {

        echo "Please fill all fields.";

    } 
    else {

        // Save data in CSV file
        $file = fopen("data.csv", "a");

        fputcsv($file, [$name, $email, $phone]);

        fclose($file);

        echo "Registration Successful!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>

<body>

<h2>Registration Form</h2>

<form method="POST">

    Name:
    <input type="text" name="name">
    <br><br>

    Email:
    <input type="text" name="email">
    <br><br>

    Phone:
    <input type="text" name="phone">
    <br><br>

    <input type="submit" name="submit" value="Register">

</form>

</body>
</html>