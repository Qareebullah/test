<?php
// Include necessary files for connection and access
include('check_access.php');
include('../includes/db_connection.php');


$Admin_id = $user_id;

if (!isset($Admin_id)) {
    header("location: login.php");
    exit();
}


$sql_check = "SELECT * FROM information WHERE Admin_id = '$Admin_id'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
  
    $showButton = false;
} else {
 
    $showButton = true;
}


if (isset($_POST['btnInfo'])) {
  
    $schoolName = $_POST['schoolName'];
    $year = $_POST['year'];
    $owner = $_POST['owner'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $male = $_POST['male'];
    $female = $_POST['female'];
    $totalEmployees = $male + $female;
    $status = $_POST['status'];

  
    $logo = $_FILES['logo']['name'];
    $Logo_dis = $_FILES['logo']['tmp_name'];
    $logo_folder = "./" . $logo;

    $image = $_FILES['image']['name'];
    $image_dis = $_FILES['image']['tmp_name'];
    $image_folder = "./" . $image;

   
    $sql = "INSERT INTO information (
        school_name, 
        Year_of_establishment, 
        `owner`, 
        `address`, 
        city, 
        Country, 
        mobile, 
        email, 
        website, 
        Number_of_Employees, 
        male_employee, 
        female_employee, 
        `status`, 
        Admin_id, 
        `image`, 
        logo
    ) 
    VALUES (
        '$schoolName', 
        '$year', 
        '$owner', 
        '$address', 
        '$city', 
        '$country', 
        '$mobile', 
        '$email', 
        '$website', 
        '$totalEmployees', 
        '$male', 
        '$female', 
        '$status', 
        '$Admin_id', 
        '$image', 
        '$logo'
    )";

   
    if ($conn->query($sql) === TRUE) {
      
        move_uploaded_file($Logo_dis, $logo_folder);
        move_uploaded_file($image_dis, $image_folder);

        echo "<script>alert('Information has been stored');</script>";
        header("location: ./");
    } else {
        die("Error executing query: " . $conn->error);
    }

  
    $conn->close();
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
    <title>Home</title>
</head>
<body>
    <div class="content-wrapper">
        <div class="container py-5">
         
            <?php if ($showButton) { ?>
            
                <button type="button" class="btn btn-outline-dark mb-4" data-toggle="modal" data-target="#test-modal">
                    Add a School
                </button>

           
                <div class="modal fade" id="test-modal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="testModalLabel">Please Enter Your School Information for the First Time</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="./index.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                  
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="schoolName" name="schoolName" placeholder="School Name" required>
                                            <input type="text" class="form-control mb-3" id="year" name="year" placeholder="Year of Establishment" required>
                                            <input type="text" class="form-control mb-3" id="owner" name="owner" placeholder="Owner" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="address" name="address" placeholder="Address" required>
                                            <input type="text" class="form-control mb-3" id="city" name="city" placeholder="City" required>
                                            <input type="text" class="form-control mb-3" id="country" name="country" placeholder="Country" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="mobile" name="mobile" placeholder="Mobile" required>
                                            <input type="email" class="form-control mb-3" id="email" name="email" placeholder="Email" required>
                                            <input type="url" class="form-control mb-3" id="website" name="website" placeholder="Website" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control mb-3" id="male" name="male" placeholder="Male Employees" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control mb-3" id="female" name="female" placeholder="Female Employees" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control mb-3" id="status" name="status" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control mb-3" id="logo" name="logo" accept="image/*" required>
                                            <input type="file" class="form-control mb-3" id="image" name="image" accept="image/*" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        <i class="fa fa-close"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-dark" name="btnInfo">
                                        <i class="fa fa-save"></i> Save Information
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
