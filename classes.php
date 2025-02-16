<?php

include('check_access.php');
include('../includes/db_connection.php');
$user_id = $_SESSION['user_id'];

if(isset($_POST['btn-insert'])){
    
    $insertSubject = $conn->query("INSERT INTO classes(class_name, grade_level, room_number, students_amount, timing, enrolled_students, students_type, class_fee, caretaker_id, staff_id, superadmin_id) 
    VALUES()");
    if($insertSubject){
        header("Location: classes.php");
    }else{
        die('Error In Your Query: '. $conn->connect_error);
    }
$conn.close();
}

if(isset($_POST['btn-update'])){


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            color: #333;
        }

        #content {
            padding: 10px;
            margin-left: 120px;
            /* To make space for sidebar */
        }

        .container {
            width: 90%;
            /* margin: 0 auto; */
        }

        .dashboard-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .stat-title {
            font-size: 22px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
            color: #2980b9;
        }
        #btn-insert{
            margin-bottom: 20px;
            float: right;
        }

        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div id="content">
        <div class="container">
            <h1 class="dashboard-title">My Classes</h1>
            <a id="btn-insert" class="btn btn-outline-success" data-toggle="modal" data-target="#insert-class-modal"><i class="fa fa-plus-circle"></i> Add New Subject</a>
            <!-- Modal -->
            <div class="modal fade" id="insert-class-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="classes.php" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><b>Please Enter Class Complete Details</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-group">
                                            <label for="subjectName"><b>Class Name</b></label>
                                            <input type="text" class="form-control" name="className" placeholder="class name..." require>
                                        </div>

                                        <div class="form-group">
                                            <label for="gradeLevel"><b>Grade Level</b></label>
                                                <select name="gradeLevel" class="form-control" require>
                                                    <option>Please grade level</option>
                                                    <option value="Nursery | Pre-Kindergarten">Nursery | Pre-Kindergarten</option>
                                                    <option value="Prep Class">Prep Class</option>
                                                    <option value="Grade 1">Grade 1</option>
                                                    <option value="Grade 2">Grade 2</option>
                                                    <option value="Grade 3">Grade 3</option>
                                                    <option value="Grade 4">Grade 4</option>
                                                    <option value="Grade 5">Grade 5</option>
                                                    <option value="Grade 6">Grade 6</option>
                                                    <option value="Grade 7">Grade 7</option>
                                                    <option value="Grade 8">Grade 8</option>
                                                    <option value="Grade 9">Grade 9</option>
                                                    <option value="Grade 10">Grade 10</option>
                                                    <option value="Grade 11">Grade 11</option>
                                                    <option value="Grade 12">Grade 12</option>
                                                </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="amount"><b>student Amount</b></label>
                                            <input type="number" class="form-control" name="amount" placeholder="student amount..." require>
                                        </div>

                                        <div class="form-group">
                                            <label for="subjectName"><b>Student Type</b></label>
                                            <select class="form-control" name="studentType" require>
                                                <option value="">please select students type</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="subjectName"><b>CareTaker</b></label>
                                            <?php $fetchTeachers = $conn->query("select id, teacherName, lastname FROM teachers");?>
                                            <select class="form-control" name="caretaker" require>
                                                <option>Please select caretaker</option>
                                                <?php if($fetchTeachers->num_rows > 0){
                                                    while($row = $fetchTeachers->fetch_assoc()){
                                                        echo "<option value='" . $row['id'] . "'>" . $row['teacherName'], $row['lastname'] . "</option>";
                                                    }

                                                    }else
                                                    {
                                                        echo "<option value=''>No options available</option>";  
                                                    }?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col">

                                        <div class="form-group">
                                            <label for="subjectName"><b>Room Number</b></label>
                                            <input type="number" class="form-control" name="roomNumber" placeholder="room number..." require>
                                        </div>

                                        <div class="form-group">
                                            <label for="currentStudents"><b>Current Students</b></label>
                                            <input type="number" class="form-control" name="currentStudents" placeholder="current students..." require>
                                        </div>

                                        <div class="form-group">
                                            <label for="subjectName"><b>Time</b></label>
                                            <select class="form-control" name="time" require>
                                                <option value="">please select time</option>
                                                <option value="Morning">Morning</option>
                                                <option value="Afternoon">Afternoon</option>
                                            </select>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="classFee"><b>Class Fee</b></label>
                                            <input type="text" class="form-control" name="classFee" placeholder="class fee..." require>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                <button type="submit" class="btn btn-outline-success" value="btn-insert"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Class</th>
                        <th scope="col">Grade Level</th>
                        <th scope="col">Room #</th>
                        <th scope="col">Time</th>
                        <th scope="col">Student Amount</th>
                        <th scope="col">Enrolled Students</th>
                        <th scope="col">Students Type</th>
                        <th scope="col">Fee</th>
                        <th scope="col">Caretaker</th>
                        <th scope="col">Add By</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $fetchClass = $conn->query("SELECT * FROM classes 
                        INNER JOIN teachers ON classes.caretaker_id = teachers.id
                        INNER JOIN staff ON classes.staff_id = staff.id WHERE classes.superadmin_id = $user_id");
                        while($row = $fetchClass->fetch_assoc()){
                     ?>
                    <tr>
                        <th scope="row"><?php echo $row['id']; ?></th>
                        <td><?php echo $row['class_name']; ?></td>
                        <td><?php echo $row['grade_level']; ?></td>
                        <td><?php echo $row['room_number']; ?></td>
                        <td><?php echo $row['timing']; ?></td>
                        <td><?php echo $row['students_amount']; ?></td>
                        <td><?php echo $row['enrolled_students']; ?></td>
                        <td><?php echo $row['students_type']; ?></td>
                        <td><?php echo $row['class_fee']; ?></td>
                        <td><?php echo $row['teacherName']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        
                        <td>
                            <a data-toggle="modal" data-target="#edit-modal<?php echo $row['id']; ?>"><i class="fa fa-pencil"></i></a>

                            <div class="modal fade" id="edit-modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Please Enter Subject's Complete Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                                <button type="submit" class="btn btn-outline-success" value="btn-update"><i class="fa fa-refresh"></i> Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to load page content into the main content area
        function loadPageContent(pageUrl) {
            $.ajax({
                url: pageUrl,
                type: 'GET',
                success: function(response) {
                    $('#main-content').html(response);
                },
                error: function() {
                    $('#main-content').html('<p>Error loading page.</p>');
                }
            });
        }

        // Sidebar click event listener
        $(document).ready(function() {
            $('#sidebar a').on('click', function(e) {
                e.preventDefault(); // Prevent default action (navigation)

                var pageUrl = $(this).attr('href'); // Get the link's href (the page URL)
                loadPageContent(pageUrl); // Load the content dynamically
            });
        });
    </script>

</body>

</html>