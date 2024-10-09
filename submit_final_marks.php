<?php
// Database connection
$servername = "localhost"; // Update with your server name
$username = "root"; // Update with your database username
$password = "Ritikshetty@16"; // Update with your database password
$dbname = "se_mini_project"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve division and subject from hidden fields
$division = $_POST['division_hidden'];
$subject = $_POST['subject_hidden'];

// Prepare to insert marks into the 'marks' table
$insertQuery = "INSERT INTO marks (division, subjects, roll_number, marks) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($insertQuery);

if ($stmt) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'marks_') === 0) { // Check if the key starts with 'marks_'
            $rollNumber = substr($key, 6); // Extract roll number from the key
            $marks = $value;

            // Bind parameters
            $stmt->bind_param("sssi", $division, $subject, $rollNumber, $marks);
            $stmt->execute();
        }
    }
    echo "<script>alert('Marks updated successfully.');</script>";
    echo "<script>window.location.href='give_marks.html';</script>";
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
