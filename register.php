<?php
session_start();
require 'db_connect.php';

if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $raw_password = $_POST['password'];
    $gender = mysqli_real_escape_string($conn, $_POST['Gender']);

    // Check if email already exists
    $check_query = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_query->bind_param("s", $email);
    $check_query->execute();
    $check_query->store_result();

    if ($check_query->num_rows > 0) {
        echo "This email is already registered. <a href='login.php'>Login here</a>";
    } else {
        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, email, password, Gender) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $gender);

        if ($stmt->execute()) {
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $first_name . ' ' . $last_name;
            header("Location: welcome.php");
            exit();
        } else {
            echo "Registration failed. Try again.";
        }

        $stmt->close();
    }

    $check_query->close();
    $conn->close();
}
?>

<!-- HTML Form same as before -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <h2>Registration Form</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <fieldset>
            <legend>Information:</legend>
            First name:<br>
            <input type="text" name="first_name" required><br>
            Last name:<br>
            <input type="text" name="last_name" required><br>
            Email:<br>
            <input type="email" name="email" required><br>
            Password:<br>
            <input type="password" name="password" required><br>
            Gender:<br>
            <input type="radio" name="Gender" value="Male" required>Male
            <input type="radio" name="Gender" value="Female">Female<br><br>
            <input type="submit" name="submit" value="Register">
        </fieldset>
    </form>
    <p>Already have  an account <a href="login.php">Login</a></p>
</body>
</html>