<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Add your own styles -->
</head>
<body>
    <div class="container">
        <h1>Scan QR Code</h1>
        <form action="scan_qr.php" method="post">
            <label for="qr_data">QR Code Data:</label>
            <textarea name="qr_data" rows="4" required></textarea>
            <br>
            <input type="submit" value="Mark Attendance">
        </form>
    </div>
</body>
</html>
