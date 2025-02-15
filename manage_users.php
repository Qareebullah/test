<?php

include('../includes/db_connection.php');
include('check_access.php');  



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $role = $_POST['role'];
    $last_name = $_POST['last_name'];
    $father_name = $_POST['father_name'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $salary_type = $_POST['salary_type'];
    $status = $_POST['status'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $superadmin_id = $user_id;




    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

  
    $sql = "INSERT INTO staff (username, `password`, `role`, last_name, father_name, province, district, position, department, salary, salary_type, `status`, email, mobile, create_at, photo, superadmin_id)
            VALUES ('$username', '$hashed_password', '$role', '$last_name', '$father_name', '$province', '$district', '$position', '$department', '$salary', '$salary_type', '$status', '$email', '$mobile', '$create_at', '$photo', '$superadmin_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New staff member added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Form</title>
</head>
<body>

    <h2>Staff Information Form</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="id">ID:</label><br>
        <input type="text" id="id" name="id" required><br><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label><br>
        <input type="text" id="role" name="role" required><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="father_name">Father's Name:</label><br>
        <input type="text" id="father_name" name="father_name" required><br><br>

        <label for="province">Province:</label><br>
        <input type="text" id="province" name="province" required><br><br>

        <label for="district">District:</label><br>
        <input type="text" id="district" name="district" required><br><br>

        <label for="position">Position:</label><br>
        <input type="text" id="position" name="position" required><br><br>

        <label for="department">Department:</label><br>
        <input type="text" id="department" name="department" required><br><br>

        <label for="salary">Salary:</label><br>
        <input type="number" id="salary" name="salary" required><br><br>

        <label for="salary_type">Salary Type:</label><br>
        <select id="salary_type" name="salary_type" required>
            <option value="Monthly">Monthly</option>
            <option value="Hourly">Hourly</option>
        </select><br><br>

        <label for="status">Status:</label><br>
        <select id="status" name="status" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="mobile">Mobile:</label><br>
        <input type="text" id="mobile" name="mobile" required><br><br>

        <label for="photo">Photo:</label><br>
        <input type="file" id="photo" name="photo" accept="image/*"><br><br>


        <input type="hidden" id="superadmin_id" name="superadmin_id" value="<?php echo $_SESSION['superadmin_id']; ?>"><br><br>


        <input type="submit" value="Submit">
    </form>

</body>
</html>
