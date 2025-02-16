<?php

include('check_access.php'); 
include('../includes/db_connection.php');

$query = "
    SELECT 
        c.class_name, 
        t.name AS teacher_name
    FROM 
        classes_teachers ct
    JOIN 
        classes c ON ct.class_id = c.id
    JOIN 
        teachers t ON ct.teacher_id = t.id
    ORDER BY 
        c.class_name, t.name
";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classes and Assigned Teachers</title>
</head>
<body>

  <h2>Classes and Assigned Teachers</h2>

  <?php

  $current_class = '';


  while ($row = $result->fetch_assoc()) {
    
      if ($current_class !== $row['class_name']) {
          if ($current_class !== '') {
        
              echo "</ul><br>";
          }
          echo "<h3>Class: " . $row['class_name'] . "</h3><ul>";
          $current_class = $row['class_name']; 
      }

      
      echo "<li>" . $row['teacher_name'] . "</li>";
  }

  
  if ($current_class !== '') {
      echo "</ul>";
  }

 
  $conn->close();
  ?>

</body>
</html>
