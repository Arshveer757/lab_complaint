<?php
$host = 'localhost'; // Database host
$db = 'pc_complaint_management'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pc_problem = $_POST['pc_problem'];
    $complaint = $_POST['complaint'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO complaints (name, email, pc_problem, complaint) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $pc_problem, $complaint);

    // Execute the statement
    if ($stmt->execute()) {
        // Prepare email
        $subject = "Complaint Submission Successful";
        $message = "Dear $name,\n\nThank you for your submission. Your complaint regarding '$pc_problem' has been received.\n\nBest regards,\nPC Complaint Management System";
        $headers = "From: arshveer757@gmail.com"; // Replace with your sender email

        // Send email
        if (mail($email, $subject, $message, $headers)) {
            echo "Complaint submitted successfully. A confirmation email has been sent to you.";
        } else {
            echo "Complaint submitted successfully, but the confirmation email could not be sent.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Complaint Form</title>
</head>
<body>
    <h2>PC Complaint Management System</h2>
    <form method="POST" action="">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="pc_problem">Type of PC Problem:</label><br>
        <select id="pc_problem" name="pc_problem" required>
            <option value="">Select a problem type</option>
            <option value="Hardware Issue">Hardware Issue</option>
            <option value="Software Issue">Software Issue</option>
            <option value="Network Issue">Network Issue</option>
            <option value="Performance Issue">Performance Issue</option>
            <option value="Other">Other</option>
        </select><br><br>

        <label for="complaint">Complaint:</label><br>
        <textarea id="complaint" name="complaint" required></textarea><br><br>

        <input type="submit" value="Submit Complaint">
    </form>
</body>
</html>
