<?php

include('check_access.php'); 
include('../includes/db_connection.php');


if (!isset($_SESSION["user_id"])) {
    die("Error: user_id is not set. Please ensure you are logged in.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if (isset($_POST['teacher_class'])) {
       
        foreach ($_POST['teacher_class'] as $teacher_class) {
    
            list($class_id, $teacher_id) = explode('_', $teacher_class);

          
            echo "Inserting: Class ID = $class_id, Teacher ID = $teacher_id<br>";

            
            $sql = "INSERT INTO classes_teachers (teacher_id, class_id, created_at) VALUES (?, ?, NOW())";

            if ($stmt = $conn->prepare($sql)) {
           
                $stmt->bind_param("ii", $teacher_id, $class_id);

             
                if ($stmt->execute()) {
                    echo "<p>Teacher assigned to class successfully!</p>";
                } else {
                    echo "Error: " . $stmt->error . "<br>";
                }

       
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error . "<br>";
            }
        }
    } else {
        echo "<p>No teachers selected.</p>";
    }
}

// Fetch all classes and teachers
$classes_result = $conn->query("SELECT id, class_name FROM classes");
$teachers_result = $conn->query("SELECT id, name FROM teachers");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assign Teachers to Classes</title>
</head>
<body>

  <h2>Assign Teachers to Classes</h2>

  <form action="" method="POST">
    <?php
 
    if ($classes_result->num_rows > 0) {
        while ($class = $classes_result->fetch_assoc()) {
            echo "<h3>Class: " . $class['class_name'] . "</h3>";

     
            if ($teachers_result->num_rows > 0) {
                while ($teacher = $teachers_result->fetch_assoc()) {
                    echo "<label><input type='checkbox' name='teacher_class[]' value='" . $class['id'] . "_" . $teacher['id'] . "'> " . $teacher['name'] . "</label><br>";
                }
            } else {
                echo "<p>No teachers available</p>";
            }

            echo "<br>"; 
        }
    } else {
        echo "<p>No classes available</p>";
    }
    ?>

    <button type="submit">Assign Selected Teachers</button>
  </form>

</body>
</html>

<?php

$conn->close();
?>
