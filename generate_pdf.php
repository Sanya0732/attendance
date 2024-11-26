<?php
require 'fpdf/fpdf.php';

// Database connection
$servername = "localhost";
$username = "root"; // Default username
$password = ""; // Default password
$dbname = "attendance_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID from the POST request
$id = $_POST['id'];

// Fetch student details from the database
$stmt = $conn->prepare("SELECT name, roll_number, subject, qr_code FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $roll_number, $subject, $qr_code);
$stmt->fetch();
$stmt->close();

$conn->close();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Student Details');
$pdf->Ln(10);
$pdf->Cell(40, 10, 'Name: ' . htmlspecialchars($name));
$pdf->Ln(10);
$pdf->Cell(40, 10, 'Roll Number: ' . htmlspecialchars($roll_number));
$pdf->Ln(10);
$pdf->Cell(40, 10, 'Subject: ' . htmlspecialchars($subject));
$pdf->Ln(10);

// Check if QR code file exists before adding it to the PDF
if (file_exists($qr_code)) {
    $pdf->Image($qr_code, 10, 80, 40, 40); // Adjust the position and size as needed
} else {
    $pdf->Cell(40, 10, 'QR Code not available.');
}

$pdf->Output();
?>
