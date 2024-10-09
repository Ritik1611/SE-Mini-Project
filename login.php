<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Ritikshetty@16";
$dbname = "se_mini_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Sanitize the input to prevent SQL injection
    $user = mysqli_real_escape_string($conn, $user);

    // Query to check for matching username in the database
    $stmt = $conn->prepare("SELECT username, pass FROM login_credentials WHERE username=?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['pass'])) {
            $_SESSION['username'] = $user;
            header("Location: teacher_dashboard.html"); 
            exit;
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Account does not exist. Redirecting to sign up...'); window.location.href='signup.html';</script>";
    }
}

$conn->close();
?>
