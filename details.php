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

// Get student ID from the URL
$id = $_GET['id'];

// Fetch student details from the database
$stmt = $conn->prepare("SELECT name, roll_number, subject, qr_code FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $roll_number, $subject, $qr_code);
$stmt->fetch();
$stmt->close();

$conn->close();

// Set the path for the QR code image
$qr_code_path = 'qrcodes/' . htmlspecialchars($qr_code); // Ensure the path is correct
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        h2 {
            font-size: 20px;
            margin-top: 20px;
            color: #333;
        }

        img {
            margin-top: 15px;
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }

        form {
            margin-top: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        @media (max-width: 400px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Details</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Roll Number:</strong> <?php echo htmlspecialchars($roll_number); ?></p>
        <p><strong>Subject:</strong> <?php echo htmlspecialchars($subject); ?></p>
        <h2>QR Code</h2>
        <img src="qrcodes/<?php echo htmlspecialchars($qr_code); ?>" alt="QR Code">

        <form action="generate_pdf.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit">Generate PDF</button>
        </form>
    </div>
</body>
</html>
