<?php
session_start();  // Ensure session is started
include('../includes/db_connection.php');



if (isset($_SESSION['id'])) {
   
    $user_id = $_SESSION['id'];

    
    $sql = "SELECT id FROM superadmins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

   
    if ($result->num_rows > 0) {
     
      
      
    } else {
      
        echo "Error: Access denied. You do not have the required permissions.";
        exit;
    }
} else {
    // User is not logged in
    echo "Error: Please log in to access this page.";
    exit;
}

?>
