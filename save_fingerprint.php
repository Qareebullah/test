<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school"; // Update with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle saving fingerprint template
if (isset($_POST['fingerprint']) && isset($_POST['id'])) {
    $student_id = $_POST['id'];
    $fingerprintTemplate = base64_decode($_POST['fingerprint']); // Decode the fingerprint from base64

    // Insert into hr_biotemplathe table
    $sql = "INSERT INTO hr_biotemplathe (student_id, fingerprint_template) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ib", $student_id, $fingerprintTemplate);

    if ($stmt->execute()) {
        echo "Fingerprint saved successfully.";
    } else {
        echo "Error saving fingerprint.";
    }
    $stmt->close();
    $conn->close();
    exit;
}
?>
