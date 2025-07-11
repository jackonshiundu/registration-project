<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
    <p>Your email: <?php echo $_SESSION['user_email']; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>