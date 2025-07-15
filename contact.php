<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
</head>
<body>
    <h2>Contact Us</h2>
    <form method="POST" action="send_contact.php">
        Name:<br>
        <input type="text" name="name" required><br>
        Email:<br>
        <input type="email" name="email" required><br>
        Message:<br>
        <textarea name="message" required></textarea><br><br>
        <input type="submit" name="send" value="Send">
    </form>
</body>
</html>
