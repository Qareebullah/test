<?php

include('../includes/db_connection.php');
include('check_access.php');  


$adminId = $user_id; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Classes</title>
    <style>
        .content-wrapper .container{
            min-width: 20vw;
            height: 85vh;
            background: #f5f5f5;
        }
        .top-title{
            text-align: center;
            margin-bottom: 20px;
        }
        #student-img{
            width: 30px;
            height: 30;
            border-radius: 50%;
        }
        h3{
             padding: 20px;
        }
    </style>
</head>
<body>
<div class="content-wrapper">
        <div class="container">
            <div class="top-title">
                <h3>Current Teaching classes</h3><hr>
            </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Grade Level</th>
                            <th>Room</th>
                            <th>Enrolled Students</th>
                            <th>Student Type</th>
                            <th>Time</th>
                            <th>Teacher</th>
                            <th>Fee</th>
                            <th>Subject</th>
                            <th>Teacher Photo</th>
                            <th>Start Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
$query = "
    SELECT 
        classes.*, 
        teachers.teacherName, 
        teachers.photo, 
        GROUP_CONCAT(subjects.subject_name ORDER BY subjects.subject_name) AS subjects_taught 
    FROM 
        classes
    INNER JOIN teachers 
        ON classes.teacher_id = teachers.id
    INNER JOIN staff 
        ON teachers.id = staff.id
    INNER JOIN subjects_teachers 
        ON teachers.id = subjects_teachers.teacher_id
    INNER JOIN subjects 
        ON subjects_teachers.subject_id = subjects.id
    WHERE 
        staff.superadmin_id = $adminId
    GROUP BY 
        classes.id, teachers.id";


$fetch = mysqli_query($conn, $query);

if (!$fetch) {
    die('Query failed: ' . mysqli_error($conn));
}

if (mysqli_num_rows($fetch) > 0) {
    while ($row = mysqli_fetch_assoc($fetch)) {
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['class_name']; ?></td>
            <td><?php echo $row['grade_level']; ?></td>
            <td><?php echo $row['room_num']; ?></td>
            <td><?php echo $row['enrolled_students']; ?></td>
            <td><?php echo $row['timing']; ?></td>
            <td><?php echo $row['teacherName']; ?></td>
            <td><?php echo $row['subjects_taught']; ?></td>
            <td>
                <?php if (!empty($row['photo'])): ?>
                    <img id="teacher-img" src="path_to_images/<?php echo $row['photo']; ?>" alt="Teacher Image">
                <?php else: ?>
                    <img id="teacher-img" src="path_to_default_image/default.jpg" alt="Default Image">
                <?php endif; ?>
            </td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='10'>No results found!</td></tr>";
}
?>


                       
                    </tbody>
                </table>
            
        </div>
    </div>
</body>
</html>