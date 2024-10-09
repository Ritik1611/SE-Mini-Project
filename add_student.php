<?php
// Database configuration
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = "Ritikshetty@16"; // Your database password
$dbname = "se_mini_project"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['student-name'];
    $division = $_POST['student-division'];
    $roll_no = $_POST['student-rollno'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO students (names, division, roll_no) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $division, $roll_no);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('New student added successfully.');</script>";
        echo "<script>window.location.href='add_student.html';</script>";
    } else {
        // Check if it's a duplicate entry error
        if ($stmt->errno == 1062) { // 1062 is the error code for duplicate entry
            echo "<script>alert('Error: A student with the same Division and Roll No already exists.');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
