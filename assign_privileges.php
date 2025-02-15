<?php
<<<<<<< HEAD
// Include your database connection file (if not already included)
include '../includes/db_connection.php';  // Assuming your connection file is named conn.php
include 'check_access.php';
// Assuming Admin_id is stored in the session

$adminId = $user_id; // Get Admin_id from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get role and selected pages from form submission
    $role = $_POST['role'];
    $selectedPages = isset($_POST['pages']) ? $_POST['pages'] : [];

    // Define the associated URLs for each page
    $rolePages = [
        'CRM' => [
            'Customer Management' => ['School/crm/add_customer.php', 'School/crm/manage_customer.php']
        ],
        'HR' => [
            'Employee Management' => ['School/hr/manage_employees.php', 'School/hr/employee_details.php']
        ],
        'Admin' => [
            'Admin Dashboard' => ['School/admin/dashboard.php', 'School/admin/settings.php']
        ]
    ];

    // First, clear existing entries for this role using MySQLi
    $stmt = $conn->prepare("DELETE FROM pages WHERE role = ? AND Admin_id = ?");
    if ($stmt === false) {
        // If prepare() fails, display the error
        die('MySQL Error: ' . $conn->error);
    }
    $stmt->bind_param("si", $role, $adminId); // "s" for string (role) and "i" for integer (Admin_id)
    $stmt->execute();

    // Then insert the selected pages for this role
    foreach ($selectedPages as $pageName) {
        // Get the associated URLs for the selected page
        $urls = $rolePages[$role][$pageName];

        // Insert each associated URL into the database with Admin_id
        foreach ($urls as $url) {
            $stmt = $conn->prepare("INSERT INTO pages (role, page_url, Admin_id) VALUES (?, ?, ?)");
            if ($stmt === false) {
                // If prepare() fails, display the error
                die('MySQL Error: ' . $conn->error);
            }
            $stmt->bind_param("ssi", $role, $url, $adminId); // "ssi" means two strings and one integer
            $stmt->execute();
        }
    }

    // Redirect or show success message
    echo "Pages assigned successfully!";
=======
include('../includes/db_connection.php'); // Include your DB configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $role = $_POST['role'];
    $pages = isset($_POST['pages']) ? $_POST['pages'] : [];

    // Insert pages for the selected role
    foreach ($pages as $page_url) {
        $page_name = basename($page_url, ".php");

        // Check if the page URL already exists for the given role
        $check_query = "SELECT * FROM pages WHERE page_url = '$page_url' AND role = '$role'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // If the page already exists for the given role, skip the insertion
            echo "Page '{$page_name}' already exists for role '{$role}'.<br>";
        } else {
            // Insert into database if no duplicate found
            $insert = "INSERT INTO pages (pagename, page_url, role) VALUES ('$page_name', '$page_url', '$role')";
            $result = mysqli_query($conn, $insert);

            if ($result) {
                echo "Page '{$page_name}' has been assigned to role '{$role}'.<br>";
            } else {
                echo "Error: " . mysqli_error($conn) . "<br>";
            }
        }
    }
>>>>>>> be2342fd31dd4a1709e816814d2aa45dfff1b09c
}
?>
