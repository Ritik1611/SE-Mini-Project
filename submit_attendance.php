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
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'division' and 'roll_no' are set in the POST request
    if (isset($_POST['division_hidden']) && isset($_POST['roll_no'])) {
        $attendance_date = date('Y-m-d'); // Current date
        $division = $_POST['division_hidden']; // Division from the form
        $roll_numbers = $_POST['roll_no']; // Array of selected roll numbers

        // Prepare the SQL statement to insert attendance records
        $stmt = $conn->prepare("INSERT INTO attendance (roll_no, division, attendance_date, attendance_status) VALUES (?, ?, ?, ?)");

        // Initialize a flag to track if any records were inserted
        $inserted = false;

        foreach ($roll_numbers as $roll_no) {
            // Attendance status input name, e.g., 'attendance_status_1'
            $attendance_status_name = 'attendance_status_' . $roll_no;

            // Get attendance status, defaulting to 'Absent' if not set
            $attendance_status = isset($_POST[$attendance_status_name]) ? $_POST[$attendance_status_name] : 'Absent'; 

            // Bind parameters and execute SQL query
            $stmt->bind_param("isss", $roll_no, $division, $attendance_date, $attendance_status);
            if ($stmt->execute()) {
                $inserted = true; // At least one record was inserted
            } else {
                // Log error for individual record insertion failure
                error_log("Failed to insert attendance for roll_no $roll_no: " . $stmt->error);
            }
        }    

        // Check for successful execution
        if ($inserted) {
            echo "<script>alert('Attendance records added successfully.');</script>";
            echo "<script>window.location.href='attendance.html';</script>";
        } else {
            echo "No attendance records were inserted.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Division or roll numbers not provided.";
    }
}

// Close the connection
$conn->close();
?>
