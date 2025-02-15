<?php
include('../includes/db_connection.php');
include('check_access.php');  


$adminId = $user_id; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_teacher'])) {
    $teacherId = $_POST['teacherId'];
    $teacherName = $_POST['teacherName'];
    $lastName = $_POST['lastName'];
    $role = $_POST['role'];
    $gender = $_POST['gender'];
    $qualification = $_POST['qualification'];
    $status = $_POST['status'];
    $subjectsTaught = $_POST['subjectsTaught'];
    $mobile = $_POST['mobile'];

  
    $updateQuery = "UPDATE teachers SET 
                        teacherName = '$teacherName', 
                        last_name = '$lastName', 
                        role = '$role', 
                        gender = '$gender', 
                        qualification = '$qualification', 
                        status = '$status', 
                        subjects_taught = '$subjectsTaught', 
                        mobile = '$mobile' 
                    WHERE id = $teacherId";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Record updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Teachers</title>
    <style>
      
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content-wrapper .container {
            min-width: 25vw;
            height: 85vh;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        table {
            font-size: 0.9rem;  
            margin-top: 20px;
        }

        th, td {
            vertical-align: middle;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #343a40;
            color: white;
            border-radius: 5px;
        }

        td {
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        #teacher-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .btn {
            font-size: 0.85rem;
            border-radius: 5px;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-close {
            font-size: 1.2rem;
        }

     
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #343a40;
            color: white;
        }

        .modal-body {
            font-size: 0.9rem;
        }

        .top-title h3 {
            font-size: 1.5rem;
            font-weight: 500;
            color: #343a40;
        }

        .top-title hr {
            border-top: 1px solid #dee2e6;
        }

       
        @media (max-width: 768px) {
            .content-wrapper .container {
                width: 100%;
                padding: 15px;
            }

            table {
                font-size: 0.8rem;
            }
        }

    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="container">
            <div class="top-title">
                <h3>Current Hired Teachers</h3><hr>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role</th>
                        <th>Gender</th>
                        <th>Qualification</th>
                        <th>Status</th>
                        <th>Teaching Subjects</th>
                        <th>Added By</th>
                        <th>Mobile</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $query = "
                        SELECT *, username as staffName 
                        FROM teachers 
                        INNER JOIN staff 
                        ON teachers.staff_id = staff.id
                        WHERE staff.superadmin_id = $adminId
                    ";
                    $fetchTeachers = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($fetchTeachers)) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['teacherName']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['qualification']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['subjects_taught']; ?></td>
                        <td><?php echo $row['staffName']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>
                        <td><img id="teacher-img" src="./<?php echo $row['photo']; ?>" alt="staff img"></td>
                        <td>
                            <a href="#" class="btn btn-info viewBtn" data-bs-toggle="modal" data-bs-target="#viewTeacherModal" 
                               data-id="<?php echo $row['id']; ?>"
                               data-teacher-name="<?php echo $row['teacherName']; ?>"
                               data-last-name="<?php echo $row['last_name']; ?>"
                               data-role="<?php echo $row['role']; ?>"
                               data-father-name="<?php echo $row['father_name']; ?>"
                               data-gender="<?php echo $row['gender']; ?>"
                               data-province="<?php echo $row['province']; ?>"
                               data-district="<?php echo $row['district']; ?>"
                               data-permanent-address="<?php echo $row['permanent_address']; ?>"
                               data-current-address="<?php echo $row['current_address']; ?>"
                               data-qualification="<?php echo $row['qualification']; ?>"
                               data-salary="<?php echo $row['salary']; ?>"
                               data-subjects-taught="<?php echo $row['subjects_taught']; ?>"
                               data-email="<?php echo $row['email']; ?>"
                               data-mobile="<?php echo $row['mobile']; ?>"
                               data-photo="<?php echo $row['photo']; ?>"
                               data-created-at="<?php echo $row['created_at']; ?>"
                               data-staff-id="<?php echo $row['staff_id']; ?>">
                               <i class="fa fa-eye"></i> View
                            </a>
                            <a href="#" class="btn btn-success editBtn" data-bs-toggle="modal" data-bs-target="#editTeacherModal" 
                               data-id="<?php echo $row['id']; ?>"
                               data-teacher-name="<?php echo $row['teacherName']; ?>"
                               data-last-name="<?php echo $row['last_name']; ?>"
                               data-role="<?php echo $row['role']; ?>"
                               data-gender="<?php echo $row['gender']; ?>"
                               data-qualification="<?php echo $row['qualification']; ?>"
                               data-status="<?php echo $row['status']; ?>"
                               data-subjects-taught="<?php echo $row['subjects_taught']; ?>"
                               data-mobile="<?php echo $row['mobile']; ?>">
                               <i class="fa fa-pencil"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    
        const viewButtons = document.querySelectorAll('.viewBtn');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('view-id').textContent = this.getAttribute('data-id');
                document.getElementById('view-teacher-name').textContent = this.getAttribute('data-teacher-name');
                document.getElementById('view-last-name').textContent = this.getAttribute('data-last-name');
                document.getElementById('view-father-name').textContent = this.getAttribute('data-father-name');
                document.getElementById('view-role').textContent = this.getAttribute('data-role');
                document.getElementById('view-gender').textContent = this.getAttribute('data-gender');
                document.getElementById('view-province').textContent = this.getAttribute('data-province');
                document.getElementById('view-district').textContent = this.getAttribute('data-district');
                document.getElementById('view-permanent-address').textContent = this.getAttribute('data-permanent-address');
                document.getElementById('view-current-address').textContent = this.getAttribute('data-current-address');
                document.getElementById('view-qualification').textContent = this.getAttribute('data-qualification');
                document.getElementById('view-salary').textContent = this.getAttribute('data-salary');
                document.getElementById('view-subjects-taught').textContent = this.getAttribute('data-subjects-taught');
                document.getElementById('view-email').textContent = this.getAttribute('data-email');
                document.getElementById('view-mobile').textContent = this.getAttribute('data-mobile');
                document.getElementById('view-photo').src = this.getAttribute('data-photo');
                document.getElementById('view-created-at').textContent = this.getAttribute('data-created-at');
                document.getElementById('view-staff-id').textContent = this.getAttribute('data-staff-id');
            });
        });

   
const editButtons = document.querySelectorAll('.editBtn');

editButtons.forEach(button => {
    button.addEventListener('click', function() {
 
        document.getElementById('edit-teacher-id').value = this.getAttribute('data-id');
        document.getElementById('edit-teacher-name').value = this.getAttribute('data-teacher-name');
        document.getElementById('edit-last-name').value = this.getAttribute('data-last-name');
        document.getElementById('edit-role').value = this.getAttribute('data-role');
        document.getElementById('edit-gender').value = this.getAttribute('data-gender');
        document.getElementById('edit-qualification').value = this.getAttribute('data-qualification');
        document.getElementById('edit-status').value = this.getAttribute('data-status');
        document.getElementById('edit-subjects-taught').value = this.getAttribute('data-subjects-taught');
        document.getElementById('edit-mobile').value = this.getAttribute('data-mobile');
    });
});

    </script>
</body>
</html>
