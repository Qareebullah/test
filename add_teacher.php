<?php

include('check_access.php'); 
include('../includes/db_connection.php');

$user_id = $_SESSION['user_id'];

$staffQuery = "SELECT superadmin_id FROM staff WHERE id = ?";
$stmt = $conn->prepare($staffQuery);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param('i', $user_id);
$stmt->execute();
$staffResult = $stmt->get_result();
$staff = $staffResult->fetch_assoc();

if($staff){
    $superadmin_id = $staff['superadmin_id'];

    // Fetch classes for the superadmin_id
    $teacherQuery = "SELECT id FROM staff WHERE superadmin_id = ?";
    $teacherStmt = $conn->prepare($teacherQuery);
    if(!$teacherStmt) {
      die("Query preparation failed: " . $conn->error);
    }
    $teacherStmt->bind_param('i', $superadmin_id);
    $teacherStmt->execute();
    $teacherResult = $teacherStmt->get_result();

    $teacher = [];
    while ($row = $teacherResult->fetch_assoc()){
        $teacher[] = $row;
    }
      // Fetch school name for the superadmin_id
      $infoQuery = "SELECT school_name FROM information WHERE Admin_id = ?";
      $infoStmt = $conn->prepare($infoQuery);
      if (!$infoStmt) {
          die("Query preparation failed: " . $conn->error);
      }
      $infoStmt->bind_param('i', $superadmin_id);
      $infoStmt->execute();
      $infoResult = $infoStmt->get_result();
      $school = $infoResult->fetch_assoc();
      $school_prefix = strtoupper(substr($school['school_name'], 0, 2)); // Get the first two letters of the school name
    } else {
        $teacher = [];
        $school_prefix = '';
      }
      $teacher = null;
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
      $class_id = $_GET['id'];

      // Fetch student data from the database
      $teacherQuery = "SELECT * FROM staff WHERE id = ?";
      $teacherStmt = $conn->prepare($teacherQuery);
      $teacherStmt->bind_param('i', $class_id);
      $teacherStmt->execute();
      $teacherResult = $teacherStmt->get_result();
      if ($teacherResult->num_rows > 0) {
          $teacher = $teacherResult->fetch_assoc();
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $role = $_POST['role'];
    $lastname = $_POST['lastname'];
    $father_name = $_POST['father_name'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $permanent_address = isset($_POST['permanent_address']) ? $_POST['permanent_address'] : '';
    $current_address = isset($_POST['current_address']) ? $_POST['current_address'] : '';
    $qualification = $_POST['qualification'];
    $salary = $_POST['salary'];
    $subjects_taught = $_POST['subjects_taught'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $sample_password = generateRandomPassword();
    $hashed_password = password_hash($sample_password, PASSWORD_DEFAULT);

    // Get the last inserted student ID and generate the new one
    $result = $conn->query("SELECT id FROM staff WHERE superadmin_id = '$superadmin_id' ORDER BY id DESC LIMIT 1");
    $lastStaff = $result->fetch_assoc();
    $lastId = $lastlastStaff ? $lastStaff['id'] : '';

    $nextIdNumber = 1;
        if ($lastId) {
            $lastIdParts = explode('-', $lastId);
            if (isset($lastIdParts[2])) {
                $nextIdNumber = (int) $lastIdParts[2] + 1;
            }
        }
    $nextId = $school_prefix.'-'.$superadmin_id.'-STF-'. str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
    $sql = "SELECT superadmin_id FROM staff WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($superadmin_id);

    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_name = $_FILES['photo']['name'];
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_path = 'uploads/' . $photo_name; 
        move_uploaded_file($photo_tmp_name, $photo_path);
        $photo = $photo_path; 
    }


    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO teachers (id, name, password, role, lastname, father_name, province, district, permanent_address, 
                                  current_address, qualification, salary, subjects_taught, email, mobile, photo, staff_id, created_at)
            VALUES ('$nextId', '$name', '$hashed_password', '$role', '$lastname', '$father_name', '$province', '$district', '$permanent_address', 
                    '$current_address', '$qualification', '$salary', '$subjects_taught', '$email', '$mobile', '$photo', '$user_id', NOW())";


    if ($conn->query($sql) === TRUE) {
        echo "<p class='alert alert-success'>Teacher data added successfully!</p>";
        echo "<p><strong>Sample Password:</strong> $sample_password</p>";  // Show the generated password
    } else {
        echo "Error: " . $conn->error;
    }
 }
}

$conn->close();


function generateRandomPassword($length = 8) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Teacher Data</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            min-height: fit-content;
            margin: 5% 0%;
            box-sizing: border-box;
            width: 80%;
        }

        .grid-item select,
        input,
        button.custom-btn,
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
            box-sizing: border-box;
            margin-top: 3%;
        }

        .grid-item select,
        input,
        button.custom-btn {
            height: 3rem;
        }

        .grid-item select:focus,
        input:focus,
        textarea:focus {
            border-color: black;
            outline: none;
        }

        .grid-item select {
            margin-top: 10.6px;
        }

        form {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .grid-item.span2 {
            grid-column: span 2;
        }

        .grid-item.span4 {
            grid-column: span 4;
        }

        .grid-item.span3 {
            grid-column: span 3;
        }

        h2,
        .last-row {
            text-align: center;
        }

        h5 {
            color: black;
            text-transform: uppercase;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .custom-btn {
            background-color: black;
            color: white;
            width: fit-content;
            padding: 10px 10%;
            border: 2px solid black !important;
            cursor: pointer;
        }

        .custom-btn:hover {
            background-color: white;
            color: black;
            border-color: black;
        }

        @media (width: 768px) {
            form {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-item.span4,
            .grid-item.span2 {
                grid-column: span 2;
            }
        }

        @media (max-width: 767px) {
            form {
                grid-template-columns: 1fr;
            }

            .grid-item.span4,
            .grid-item.span2 {
                grid-column: span 1;
            }

            .form-container {
                padding: 10px;
                max-width: 100%;
            }
        }

        .error,
        select.error,
        .error:focus {
            border-color: red;
        }

        .error-message {
            color: red;
            font-size: 0.8rem;
            visibility: hidden;
        }

        .required {
            color: red;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="form-container">
            <h2 class="form-heading">Enter Teacher Data</h2>

            <form id="teacherForm" action="" method="POST" enctype="multipart/form-data">
                <div class="grid-item span4">
                    <h5>Personal Information:</h5>
                </div>

                <div class="grid-item span2">
                    <label for="name">Name:</label>
                    <span class="required">*</span>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Teacher first name...">
                    <div class="error-message" id="nameError">Name is required.</div>
                </div>

                <div class="grid-item span2">
                    <label for="lastname">Last Name:</label>
                    <span class="required">*</span>
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Teacher last name...">
                    <div class="error-message" id="lastnameError">Last name is required.</div>
                </div>

                <div class="grid-item span4">
                    <label for="father_name">Father's Name:</label>
                    <span class="required">*</span>
                    <input type="text" id="father_name" name="father_name" class="form-control" placeholder="Teacher father's name...">
                    <div class="error-message" id="fatherNameError">Father's name is required.</div>
                </div>

                <div class="grid-item span4">
                    <h5>Location Information:</h5>
                </div>

                <div class="grid-item span2">
                    <label for="province">Province:</label>
                    <span class="required">*</span>
                    <select id="province" name="province" class="form-control">
                        <option value="">Select province</option>
                        <option value="Badakhshan">Badakhshan</option>
                        <option value="Badghis">Badghis</option>
                        <option value="Baghlan">Baghlan</option>
                        <option value="Balkh">Balkh</option>
                        <option value="Bamyan">Bamyan</option>
                        <option value="Daykundi">Daykundi</option>
                        <option value="Farah">Farah</option>
                        <option value="Faryab">Faryab</option>
                        <option value="Ghazni">Ghazni</option>
                        <option value="Ghor">Ghor</option>
                        <option value="Helmand">Helmand</option>
                        <option value="Herat">Herat</option>
                        <option value="Jowzjan">Jowzjan</option>
                        <option value="Kabul">Kabul</option>
                        <option value="Kandahar">Kandahar</option>
                        <option value="Kapisa">Kapisa</option>
                        <option value="Khost">Khost</option>
                        <option value="Kunar">Kunar</option>
                        <option value="Kunduz">Kunduz</option>
                        <option value="Laghman">Laghman</option>
                        <option value="Logar">Logar</option>
                        <option value="Nangarhar">Nangarhar</option>
                        <option value="Nimroz">Nimroz</option>
                        <option value="Nuristan">Nuristan</option>
                        <option value="Paktia">Paktia</option>
                        <option value="Paktika">Paktika</option>
                        <option value="Panjshir">Panjshir</option>
                        <option value="Parwan">Parwan</option>
                        <option value="Samangan">Samangan</option>
                        <option value="Sar-e Pol">Sar-e Pol</option>
                        <option value="Takhar">Takhar</option>
                        <option value="Urozgan">Urozgan</option>
                        <option value="Wardak">Wardak</option>
                        <option value="Zabul">Zabul</option>
                    </select>
                    <div class="error-message" id="provinceError">Province is required.</div>
                </div>

                <div class="grid-item span2">
                    <label for="district">District:</label>
                    <span class="required">*</span>
                    <input type="text" id="district" name="district" class="form-control" placeholder="Select district">
                    <div class="error-message" id="districtError">District is required.</div>
                </div>

                <div class="grid-item span2">
                    <label for="permanent_address">Permanent Address:</label>
                    <span class="required">*</span>
                    <textarea id="permanent_address" name="permanent_address" class="form-control" rows="3" placeholder="Permanent address"></textarea>
                    <div class="error-message" id="permanentAddressError">Permanent address is required.</div>
                </div>

                <div class="grid-item span2">
                    <label for="current_address">Current Address:</label>
                    <span class="required">*</span>
                    <textarea id="current_address" name="current_address" class="form-control" rows="3" placeholder="Current address"></textarea>
                    <div class="error-message" id="currentAddressError">Current address is required.</div>
                </div>

                <div class="grid-item span4">
                    <h5>Additional Information:</h5>
                </div>

                <div class="grid-item">
                    <label for="qualification">Qualification:</label>
                    <span class="required">*</span>
                    <input type="text" id="qualification" name="qualification" class="form-control" placeholder="Teacher qualification">
                    <div class="error-message" id="qualificationError">Qualification is required.</div>
                </div>

                <div class="grid-item">
                    <label for="salary">Salary:</label>
                    <span class="required">*</span>
                    <input type="number" id="salary" name="salary" class="form-control" placeholder="Salary">
                    <div class="error-message" id="salaryError">Salary is required.</div>
                </div>

                <div class="grid-item">
                    <label for="mobile">Mobile:</label>
                    <span class="required">*</span>
                    <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="+937 ...">
                    <div class="error-message" id="mobileError">Mobile number is required.</div>
                </div>

                <div class="grid-item">
                    <label for="email">Email:</label>
                    <span class="required">*</span>
                    <input type="email" id="email" name="email" class="form-control" placeholder="example@.com">
                    <div class="error-message" id="emailError">Email is required.</div>
                </div>

                <div class="grid-item span4">
                    <label for="photo">Photo:</label>
                    <input type="file" id="photo" name="photo" class="form-control">
                </div>

                <div class="grid-item span4 last-row">
                    <input class="custom-btn" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>


    <div class="footer">
        <p>&copy; 2025 School Management System. All rights reserved.</p>
    </div>

    <script>
        $("#province").change(function() {
            var province = $(this).val();
            if (province) {
                $.ajax({
                    type: "GET",
                    url: "get_districts.php",
                    data: {
                        province: province
                    },
                    success: function(response) {
                        var districts = JSON.parse(response);
                        var districtSelect = $("#district");
                        districtSelect.empty();
                        districtSelect.append('<option value="">Select District</option>');

                        if (districts.length > 0) {
                            $.each(districts, function(index, district) {
                                districtSelect.append('<option value="' + district.district + '">' + district.district + '</option>');
                            });
                        } else {
                            districtSelect.append('<option value="">No districts available</option>');
                        }
                    },
                    error: function() {
                        alert("Error loading districts.");
                    }
                });
            } else {
                $("#district").html('<option value="">Select District</option>');
            }
        });

        // JavaScript Validation for all the fields
        document.getElementById('teacherForm').addEventListener('submit', function(event) {
            let isValid = true;
            let firstEmptyField = null;
            const requiredFields = [{
                    id: 'name',
                    errorId: 'nameError'
                },
                {
                    id: 'lastname',
                    errorId: 'lastnameError'
                },
                {
                    id: 'father_name',
                    errorId: 'fatherNameError'
                },
                {
                    id: 'province',
                    errorId: 'provinceError'
                },
                {
                    id: 'district',
                    errorId: 'districtError'
                },
                {
                    id: 'permanent_address',
                    errorId: 'permanentAddressError'
                },
                {
                    id: 'current_address',
                    errorId: 'currentAddressError'
                },
                {
                    id: 'qualification',
                    errorId: 'qualificationError'
                },
                {
                    id: 'salary',
                    errorId: 'salaryError'
                },
                {
                    id: 'mobile',
                    errorId: 'mobileError'
                },
                {
                    id: 'email',
                    errorId: 'emailError'
                }
            ];

            requiredFields.forEach(field => {
                const input = document.getElementById(field.id);
                const error = document.getElementById(field.errorId);
                input.addEventListener('input', function() {
                    if (error.style.visibility === 'visible') {
                        error.style.visibility = 'hidden';
                        input.classList.remove('error');
                    }
                });
                if (!input.value) {
                    error.style.visibility = 'visible';
                    input.classList.add('error');
                    isValid = false;

                    if (!firstEmptyField) {
                        firstEmptyField = input;
                    }
                } else {
                    error.style.visibility = 'hidden';
                    input.classList.remove('error');
                }
            });

            if (!isValid) {
                event.preventDefault();
                if (firstEmptyField) {
                    firstEmptyField.focus();
                }
            }
        });
    </script>

</body>

</html>