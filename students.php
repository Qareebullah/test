<?php
// session_start();
include('../includes/db_connection.php');
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Students</title>
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
                <h3>Current Enrolled Students</h3><hr>
            </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>Father</th>
                            <th>Gender</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Age</th>
                            <th>Current Class</th>
                            <th>Asas Number</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $query = "SELECT *, class_name FROM students INNER JOIN classes ON students.class_id  = classes.id ";
                        $fetchStudents = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($fetchStudents)) {?>
                        <tr>
                            <td>
                                <td><?php  echo $row['name'];?></td>
                                <td><?php  echo $row['lastname'];?></td>
                                <td><?php  echo $row['father_name'];?></td>
                                <td><?php  echo $row['gender'];?></td>
                                <td>class name</td>
                                <td><?php  echo $row['status'];?></td>
                                <td><?php  echo $row['age'];?></td>
                                <td><?php  echo $row['class_name'];?></td>
                                <td><?php  echo $row['asas_num'];?></td>
                                <td><img id="student-img" src=""  alt="staff img"></td>
                                <td>
                                    <!-- print complete record fo clicked student in the modal -->
                                    <a href=""><i class="fa fa-eye"></i></a> 

                                    <!--  edit the selected record in the modal -->
                                    <a href=""><i class="fa fa-pencil"></i></a>
                                </td>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            
        </div>
    </div>
</body>
</html>