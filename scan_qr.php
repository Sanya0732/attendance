<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username
$password = ""; // Default password
$dbname = "attendance_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if QR code data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qr_data = $_POST['qr_data']; // This is the scanned QR data

    // Extract roll number from the QR code data
    preg_match('/Roll Number: (\w+)/', $qr_data, $matches);
    $roll_number = $matches[1] ?? null; // Get the roll number if it exists

    if ($roll_number) {
        // Mark attendance in the database (you can create an attendance table)
        $stmt = $conn->prepare("INSERT INTO attendance (roll_number, attended_at) VALUES (?, NOW())");
        $stmt->bind_param("s", $roll_number);

        if ($stmt->execute()) {
            echo "Attendance marked successfully for Roll Number: " . htmlspecialchars($roll_number);
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid QR code data.";
    }
}

$conn->close();
?>
