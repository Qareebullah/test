<?php
// Include check_access.php to fetch user_id from the session
include('check_access.php');  // Assuming this file handles the session and user validation

// Check if user_id is set in the session after including check_access.php
if (!isset($_SESSION['user_id'])) {
    die("You are not authorized to view this page.");
}

$user_id = $_SESSION['user_id']; // Get user_id from session

// Database connection setup
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "school"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the superadmin_id for the logged-in user (user_id)
$sql_superadmin = "SELECT superadmin_id FROM staff WHERE id = ?";
$stmt = $conn->prepare($sql_superadmin);
$stmt->bind_param("i", $user_id); // Bind the user_id to get the superadmin_id
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($superadmin_id);

if ($stmt->num_rows === 0) {
    die("No staff member found for the given user_id.");
}

$stmt->fetch();
$stmt->close();


$sql = "
    SELECT c.*, s.id AS staff_id, s.superadmin_id
    FROM classes c
    INNER JOIN staff s ON c.staff_id = s.id
    WHERE s.superadmin_id = ?
";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $superadmin_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Class ID</th><th>Class Name</th><th>Staff ID</th><th>Superadmin ID</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['class_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['staff_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['superadmin_id']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}


$stmt->close();
$conn->close();
?>
