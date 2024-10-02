<?php
// Database connection
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = "Ritikshetty@16"; // Replace with your database password
$dbname = "se_mini_project"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email']; // Get email from the form

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM login_credentials WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        echo "<script>alert('Username already exists. Please choose another one.');</script>";
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO login_credentials (username, pass, email) VALUES (?, ?, ?)"); // Include email here
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $stmt->bind_param("sss", $username, $hashed_password, $email); // Bind email as well

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! You can now log in.'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Error occurred during registration. Please try again.');</script>";
        }
    }

    $stmt->close();
}

$conn->close();
?>
