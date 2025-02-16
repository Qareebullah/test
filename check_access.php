<?php
session_start();


$host = 'localhost';
$dbname = 'school';
$username = 'root';
$password = '';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function checkAccess($page_url) {
   
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");  
        exit();
    }

    $user_id = $_SESSION['user_id'];  

  
    try {
        $stmt = $GLOBALS['conn']->prepare("SELECT role FROM staff WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            header("Location: ../login/login.php");  
            exit();
        }

        $user_role = $user['role'];

   
        $base_url = strtok($page_url, '?');

     
        $stmt = $GLOBALS['conn']->prepare("SELECT role FROM pages WHERE page_url = :page_url");
        $stmt->bindParam(':page_url', $base_url);
        $stmt->execute();
        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$page) {
            header("Location: error.php?error=Page not found");  
            exit();
        }

       
        if ($user_role == $page['role']) {
            return true;  
        } else {
            header("Location: error.php?error=Access denied for your role");  
            exit();
        }
    } catch (PDOException $e) {
      
        error_log($e->getMessage());
        header("Location: error.php?error=An error occurred");
        exit();
    }
}
