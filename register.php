<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "john_doe";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $raw_password = $_POST['password'];
    $gender = mysqli_real_escape_string($conn, $_POST['Gender']);

    // Hash the password
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `Gender`)
            VALUES (?, ?, ?, ?, ?)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $gender);

    if ($stmt->execute()) {
        // Store user data in session
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $first_name . ' ' . $last_name;

        // Redirect to welcome page
        header("Location: welcome.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

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
</body>
</html>