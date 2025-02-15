<?php
session_start();


if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";  // Your database username
$password = "";      // Your database password
$dbname = "school";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$session_id = $_SESSION['id'];

$sql = "
    SELECT c.*, s.superadmin_id 
    FROM classes c 
    JOIN staff s ON c.staff_id = s.id
    WHERE s.superadmin_id = '$session_id'
";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<h1>Classes Managed by You:</h1>";
    
 
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
        echo "<p><strong>Class Name:</strong> " . htmlspecialchars($row['class_name']) . "</p>";
        echo "<p><strong>Grade Level:</strong> " . htmlspecialchars($row['grade_level']) . "</p>";
        echo "<p><strong>Room Number:</strong> " . htmlspecialchars($row['room_number']) . "</p>";
        echo "<p><strong>Students Amount:</strong> " . htmlspecialchars($row['students_amount']) . "</p>";
        echo "<p><strong>Timing:</strong> " . htmlspecialchars($row['timing']) . "</p>";
        echo "<p><strong>Enrolled Students:</strong> " . htmlspecialchars($row['enrolled_students']) . "</p>";
        echo "<p><strong>Students Type:</strong> " . htmlspecialchars($row['students_type']) . "</p>";
        echo "<p><strong>Created At:</strong> " . htmlspecialchars($row['created_at']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No classes found for your staff ID.</p>";
}

$conn->close();
?>
