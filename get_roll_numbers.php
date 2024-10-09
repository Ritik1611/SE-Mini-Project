<?php
// Database configuration
$servername = "localhost"; 
$username = "root"; 
$password = "Ritikshetty@16"; 
$dbname = "se_mini_project"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(["error" => "Database connection failed."]);
    exit();
}

// Get the division from the query parameter and sanitize it
$division = isset($_GET['division']) ? trim($_GET['division']) : '';

if (empty($division)) {
    echo json_encode(["error" => "Division parameter is required."]);
    exit();
}

// Prepare and execute the SQL statement
$stmt = $conn->prepare("SELECT roll_no FROM students WHERE division = ?");
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    echo json_encode(["error" => "Failed to prepare SQL statement."]);
    exit();
}

$stmt->bind_param("s", $division);
$stmt->execute();
$result = $stmt->get_result();

// Check for errors during execution
if (!$result) {
    error_log("Execution failed: " . $stmt->error);
    echo json_encode(["error" => "Failed to execute SQL statement."]);
    exit();
}

$rollNumbers = [];
while ($row = $result->fetch_assoc()) {
    $rollNumbers[] = $row['roll_no'];
}

// Return the roll numbers as a JSON response
header('Content-Type: application/json'); // Set the header to indicate JSON response
echo json_encode($rollNumbers);

// Close the connection
$stmt->close();
$conn->close();
?>
