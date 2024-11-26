<?php
// Include the QR code library
require 'qr_lib/qrlib.php';

// Database connection
$servername = "localhost";
$username = "root"; // Default username
$password = ""; // Default password
$dbname = "attendance_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $roll_number = $_POST['roll_number'];
    $subject = $_POST['subject'];

    // Generate QR code
    $qr_data = "Name: $name, Roll Number: $roll_number, Subject: $subject";
    $qr_code_file = "qrcodes/" . uniqid() . ".png"; // Create a unique file name
    QRcode::png($qr_data, $qr_code_file);

    // Check if QR code file was created
    if (file_exists($qr_code_file)) {
        echo "QR Code created successfully: " . $qr_code_file;

        // Store details in the database
        $stmt = $conn->prepare("INSERT INTO students (name, roll_number, subject, qr_code) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $roll_number, $subject, $qr_code_file);

        if ($stmt->execute()) {
            // Redirect to the details page
            header("Location: details.php?id=" . $stmt->insert_id);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Failed to create QR Code.";
    }

    $stmt->close();
}

$conn->close();
?>
