<?php
include('check_access.php');
include('../includes/db_connection.php');


$Admin_id = $user_id;

if(isset($_POST['btn-register'])){


  
    // Don't forget to fix the folder variable name $folder and ensure $imag is correct
    $insert = $conn->prepare("INSERT INTO staff(username, `password`, `role`, last_name, father_name, gender, province, district, position, department, salary, salary_type, `status`, email, mobile, photo, superAdmin_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    move_uploaded_file($dis, $folder);
    $insert->bind_param('ssssssssssisssssi', $firstName, $password, $role, $lastName, $fatherName, $gender, $province, $district, $position, $dept, $salary, $type, $status, $email, $mobile, $imag, $Admin_id);
    
    if($insert){
        header("location:./");
    }else{
        die('Error in the query: '.$conn->connect_error);
    }

    $insert->execute();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <title>Register New Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<<<<<<< HEAD
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

=======
>>>>>>> be2342fd31dd4a1709e816814d2aa45dfff1b09c
    <style>
    
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .content-wrapper {
            margin-top: 30px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .top-title {
            text-align: left;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 24px;
            color: #343a40;
        }

        .add-staff-btn {
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
            border: 1px solid #ddd;
        }

        .table th, .table td {
            text-align: left;
            padding: 12px;
        }

        .table th {
            background-color: #f1f1f1;
            color: #343a40;
            font-weight: bold;
        }

        .table td {
            background-color: #fff;
        }

        .table img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .table a {
            text-decoration: none;
        }

        .btn {
            margin-right: 5px;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .modal-header {
            background-color: #f8f9fa;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            background-color: #f1f1f1;
        }

        .modal-title {
            color: #343a40;
        }
    </style>

</head>
<body>
    <div class="content-wrapper">
        <div class="container">
            <div class="top-title">
                <h3>Current Registered Staff</h3><hr>
<<<<<<< HEAD
                <!-- Add New Staff Button (Triggers the Modal) -->
<button class="btn btn-outline-success float-end add-staff-btn" id="addNewStaffBtn">Add New Staff</button>

<!-- Modal Structure -->
<div class="modal fade" id="add-new-staff-modal" tabindex="-1" aria-labelledby="addNewStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewStaffModalLabel">Manage Users</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- iframe to load manage_users.php -->
        <iframe src="manage_users.php" style="width:100%; height:500px;" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    // JavaScript to trigger the modal when the button is clicked
    document.getElementById('addNewStaffBtn').addEventListener('click', function() {
        var myModal = new bootstrap.Modal(document.getElementById('add-new-staff-modal'));
        myModal.show();
    });
</script>

=======
                <button class="btn btn-outline-success float-end add-staff-btn" data-toggle="modal" data-target="#add-new-staff-modal">Add New Staff</button>

>>>>>>> be2342fd31dd4a1709e816814d2aa45dfff1b09c
          
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Role</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Join Date</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
             
                    $query = "SELECT * FROM staff WHERE superAdmin_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $Admin_id);  
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['position']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                            <td><?php echo $row['create_at']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['mobile']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><img src="./<?php echo $row['photo']; ?>" alt="staff img"></td>
                            <td>
                            
                                <a href="#" class="btn btn-info" title="view record"><i class="fa fa-eye"></i></a> 
                                <a href="#" class="btn btn-success" title="edit record"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
