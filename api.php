<?php

// Database 1 (Source DB) connection details
define('SOURCE_DB_HOST', 'localhost');
define('SOURCE_DB_USERNAME', 'root');
define('SOURCE_DB_PASSWORD', '');
define('SOURCE_DB_NAME', 'school');

// Database 2 (Destination DB) connection details
define('DEST_DB_HOST', 'localhost');
define('DEST_DB_USERNAME', 'admin');
define('DEST_DB_PASSWORD', 'admin123');
define('DEST_DB_NAME', 'test');

// Source DB connection
function getSourceDBConnection() {
    $conn = new mysqli(SOURCE_DB_HOST, SOURCE_DB_USERNAME, SOURCE_DB_PASSWORD, SOURCE_DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Destination DB connection
function getDestDBConnection() {
    $conn = new mysqli(DEST_DB_HOST, DEST_DB_USERNAME, DEST_DB_PASSWORD, DEST_DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Enable CORS


// Fetch ID from Source DB
function fetchIdFromSource() {
    $conn = getSourceDBConnection();
    $sql = "SELECT id FROM staff LIMIT 1"; // Fetch 1 ID (you can modify as needed)
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the first row and return the ID
        $row = $result->fetch_assoc();
        return $row['id'];
    } else {
        return null; // No ID found
    }
}

// Insert ID into Destination DB
function insertIdIntoDest($id) {
    $conn = getDestDBConnection();
    $stmt = $conn->prepare("INSERT INTO hr_employee (staff_id) VALUES (?)");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Main logic
$id = fetchIdFromSource();
if ($id) {
    if (insertIdIntoDest($id)) {
        echo json_encode(["status" => "success", "message" => "ID inserted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to insert ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No ID found in source DB"]);
}



// Step 1: Connect to the initial database where the school name is stored
$initialDbHost = 'localhost';
$initialDbUser = 'root';
$initialDbPass = '';
$initialDbName = 'motherdb';

$initialDbConn = new mysqli($initialDbHost, $initialDbUser, $initialDbPass, $initialDbName);

// Check the connection to the initial database
if ($initialDbConn->connect_error) {
    die("Initial database connection failed: " . $initialDbConn->connect_error);
}

// Step 2: Query the initial database to get the school name
$schoolNameQuery = "SELECT school_name FROM schools WHERE id = 1"; // Example query to get the school name
$result = $initialDbConn->query($schoolNameQuery);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $schoolName = $row['school_name'];  // Example: "AAA"
} else {
    die("School not found in the database");
}

// Step 3: Dynamically include the configuration file based on the school name
$configFile = $schoolName . '.php';  // E.g., "AAA.php", "BBB.php"

if (file_exists($configFile)) {
    include_once($configFile);  // Include the specific school's database configuration file
} else {
    die("Configuration file for {$schoolName} not found.");
}

// Step 4: Use the credentials from the included config file to connect to the school’s database
// Assuming the configuration file defines variables such as:
// $dbHost, $dbUser, $dbPass, $dbName

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName); // $dbHost, $dbUser, etc. are set in the school-specific config file

// Check the connection to the school’s database
if ($conn->connect_error) {
    die("Connection to the school database failed: " . $conn->connect_error);
}

echo "Successfully connected to the {$schoolName} database!";

// You can now proceed with operations in the school’s database...







?>