<?php
include('check_access.php');
include('../includes/db_connection.php');
// $user_id = $_SESSION['user_id'];

// Fetch superadmin_id based on the user_id
$staffQuery = "SELECT mother_id FROM staff WHERE id = ?";
$stmt = $conn->prepare($staffQuery);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param('i', $user_id);
$stmt->execute();
$staffResult = $stmt->get_result();
$staff = $staffResult->fetch_assoc();

if ($staff) {
    $superadmin_id = $staff['superadmin_id'];

    // Fetch classes for the superadmin_id
    $classQuery = "SELECT id, class_name FROM classes WHERE superadmin_id = ?";
    $classStmt = $conn->prepare($classQuery);
    if (!$classStmt) {
        die("Query preparation failed: " . $conn->error);
    }
    $classStmt->bind_param('i', $superadmin_id);
    $classStmt->execute();
    $classResult = $classStmt->get_result();

    $classes = [];
    while ($row = $classResult->fetch_assoc()) {
        $classes[] = $row;
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
    $classes = [];
    $school_prefix = '';
}

$student = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student data from the database
    $studentQuery = "SELECT * FROM students WHERE id = ?";
    $studentStmt = $conn->prepare($studentQuery);
    $studentStmt->bind_param('i', $student_id);
    $studentStmt->execute();
    $studentResult = $studentStmt->get_result();
    if ($studentResult->num_rows > 0) {
        $student = $studentResult->fetch_assoc();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate that required fields are set
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $father_name = isset($_POST['father_name']) ? $_POST['father_name'] : '';
    $grandfather_name = isset($_POST['grandfather_name']) ? $_POST['grandfather_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $province = isset($_POST['province']) ? $_POST['province'] : '';
    $district = isset($_POST['district']) ? $_POST['district'] : '';
    $village = isset($_POST['village']) ? $_POST['village'] : '';
    $tazkira_num = isset($_POST['tazkira_num']) ? $_POST['tazkira_num'] : '';
    $page_num = isset($_POST['page_num']) ? $_POST['page_num'] : '';
    $cover_num = isset($_POST['page_num']) ? $_POST['cover_num'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $native_language = isset($_POST['native_language']) ? $_POST['native_language'] : '';
    $asas_num = isset($_POST['asas_num']) ? $_POST['asas_num'] : '';
    $father_job = isset($_POST['father_job']) ? $_POST['father_job'] : '';
    $brother = isset($_POST['brother']) ? $_POST['brother'] : '';
    $uncle = isset($_POST['uncle']) ? $_POST['uncle'] : '';
    $mama = isset($_POST['uncle-2']) ? $_POST['uncle-2'] : '';
    $uncles_son = isset($_POST['uncles_son']) ? $_POST['uncles_son'] : '';
    $maternal_cousin = isset($_POST['maternal_cousin']) ? $_POST['maternal_cousin'] : '';
    $current_address = isset($_POST['current_address']) ? $_POST['current_address'] : '';
    $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';

    // Get the last inserted student ID and generate the new one
    $result = $conn->query("SELECT id FROM students WHERE superadmin_id = '$superadmin_id' ORDER BY id DESC LIMIT 1");
    $lastStudent = $result->fetch_assoc();
    $lastId = $lastStudent ? $lastStudent['id'] : '';

    $nextIdNumber = 1;
    if ($lastId) {
        $lastIdParts = explode('-', $lastId);
        if (isset($lastIdParts[2])) {
            $nextIdNumber = (int) $lastIdParts[2] + 1;
        }
    }

    $nextId = $school_prefix . '-' . $superadmin_id . '-STD' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

  // Handle file upload for multiple files
$file_uploaded = false;
$uploaded_files = []; // To store names of successfully uploaded files

// Check if files were uploaded
if (isset($_FILES['files']) && count($_FILES['files']['name']) > 0) {
    $upload_dir = __DIR__ . '/files/';

    // Ensure the directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
    }

    // Loop through each uploaded file
    foreach ($_FILES['files']['name'] as $key => $file_name) {
        // Check for errors
        if ($_FILES['files']['error'][$key] == 0) {
            $file_tmp = $_FILES['files']['tmp_name'][$key];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

            // Generate a unique file name based on student ID and extension
            $new_file_name = $nextId . '-' . $key . '.' . $file_ext;

            // Move the file to the upload directory
            if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
                $uploaded_files[] = $new_file_name;
                $file_uploaded = true;
            } else {
                echo "Failed to move uploaded file: " . $file_name;
            }
        } else {
            echo "Error in file upload: " . $_FILES['files']['error'][$key];
        }
    }

    if ($file_uploaded) {
        echo "Files uploaded successfully.";
    } else {
        echo "No files were uploaded successfully.";
    }
} else {
    echo "No files uploaded.";
}


    // Insert or update student record
    if ($student) {
        // Update query
        $sql = "UPDATE students SET 
                name = '$name', 
                lastname = '$lastname', 
                father_name = '$father_name', 
                grandfather_name = '$grandfather_name', 
                gender = '$gender', 
                province = '$province', 
                district = '$district', 
                tazkira_num = '$tazkira_num', 
                age = '$age', 
                dob = '$dob', 
                status = '$status', 
                native_language = '$native_language', 
                asas_num = '$asas_num', 
                father_job = '$father_job', 
                brother = '$brother', 
                uncle = '$uncle', 
                uncles_son = '$uncles_son', 
                maternal_cousin = '$maternal_cousin', 
                current_address = '$current_address', 
                updated_at = NOW(), 
                class_id = '$class_id', 
                files = '$file_name', 
                superadmin_id = '$superadmin_id' 
                WHERE id = '$student_id'";
    } else {
        // Insert query
        $sql = "INSERT INTO students (id, name, lastname, father_name, grandfather_name, gender, province, district, village, tazkira_num, page_num, cover_name, age, dob, status, native_language, asas_num, father_job, brother, uncle, mama, uncles_son, maternal_cousin, current_address, created_at, class_id, files, superadmin_id) 
                VALUES ('$nextId', '$name', '$lastname', '$father_name', '$grandfather_name', '$gender', '$province', '$district', '$village', '$tazkira_num', '$page_num', '$cover_num', '$age', '$dob', '$status', '$native_language', '$asas_num', '$father_job', '$brother', '$uncle', '$mama' ,'$uncles_son', '$maternal_cousin', '$current_address', NOW(), '$class_id', '$file_name', '$superadmin_id')";
    }
    if ($conn->query($sql) === TRUE) {
        echo "Record added/updated successfully with ID: $nextId";
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
    <title>Student Form</title>
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
            color: rgba(0, 0, 0, 0.8);
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
            margin-top: 7.583px;
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
            border: 2px solid black;
            cursor: pointer;
        }

        .custom-btn:hover {
            background-color: white;
            color: black;
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
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="form-container">
            <h2>Please Add New Student</h2>
            <form id="studentForm" action="add_student.php" method="POST" enctype='multipart/form-data'>
                <div class="grid-item span4">
                    <h5>Personal Information:</h5>
                </div>

                <div class="grid-item span4">
                    <label for="status">Status:</label>
                    <span class="required">*</span>
                    <select id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="New Student">New Student</option>
                        <option value="Bring C-parcha">Bring C-Parcha</option>
                        <option value="Temperary">Temperary</option>
                        <option value="Take C-Parcha">Take C-Parcha</option>
                    </select>
                    <div class="error-message" id="statusError">Status is required.</div>
                </div>

                <div class="grid-item">
                    <label for="name">Name:</label>
                    <span class="required">*</span>
                    <input type="text" id="name" name="name">
                    <div class="error-message" id="nameError">Name is required.</div>
                </div>

                <div class="grid-item">
                    <label for="lastname">Lastname:</label>
                    <span class="required">*</span>
                    <input type="text" id="lastname" name="lastname">
                    <div class="error-message" id="lastnameError">Lastname is required.</div>
                </div>

                <div class="grid-item">
                    <label for="father_name">Father Name:</label>
                    <span class="required">*</span>
                    <input type="text" id="father_name" name="father_name">
                    <div class="error-message" id="fatherNameError">Father name is required.</div>
                </div>

                <div class="grid-item">
                    <label for="grandfather_name">Grandfather Name:</label>
                    <span class="required">*</span>
                    <input type="text" id="grandfather_name" name="grandfather_name">
                    <div class="error-message" id="grandfatherNameError">Grandfather name is required.</div>
                </div>

                <div class="grid-item span2">
                    <label for="gender">Gender:</label>
                    <span class="required">*</span>
                    <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <div class="error-message" id="genderError">Gender is required.</div>
                </div>

                <div class="grid-item">
                    <label for="dob">Date of Birth:</label>
                    <span class="required">*</span>
                    <input type="date" id="dob" name="dob" onchange="calculateAge()">
                    <div class="error-message" id="dobError">Date of birth is required.</div>
                </div>

                <div class="grid-item">
                    <label for="age">Age:</label>
                    <span class="required">*</span>
                    <input type="number" id="age" name="age" readonly>
                    <div class="error-message" id="ageError">Age is required.</div>
                </div>

                <script>
                    function calculateAge() {
                        const dobInput = document.getElementById("dob").value;
                        const dob = new Date(dobInput);
                        const today = new Date();

                        let age = today.getFullYear() - dob.getFullYear();
                        const monthDifference = today.getMonth() - dob.getMonth();

                        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                            age--;
                        }
                        document.getElementById("age").value = age;
                    }
                </script>

                <div class="grid-item span4">
                    <h5>Identification Information:</h5>
                </div>

                <div class="grid-item">
                    <label for="tazkira_num">Tazkira Number:</label>
                    <span class="required">*</span>
                    <input type="text" id="tazkira_num" name="tazkira_num">
                    <div class="error-message" id="tazkiraError">Tazkira number is required.</div>
                </div>

                <div class="grid-item">
                    <label for="page_num">Page Number:</label>
                    <span class="required">*</span>
                    <input type="text" id="page_num" name="page_num">
                    <div class="error-message" id="pageError">page number is required.</div>
                </div>

                <div class="grid-item">
                    <label for="cover_num">Cover Number:</label>
                    <span class="required">*</span>
                    <input type="text" id="cover_num" name="cover_num">
                    <div class="error-message" id="coverError">cover number is required.</div>
                </div>

                <div class="grid-item">
                    <label for="asas_num">Asas Number:</label>
                    <span class="required">*</span>
                    <input type="text" id="asas_num" name="asas_num">
                    <div class="error-message" id="asasNumError">Asas number is required.</div>
                </div>

                <div class="grid-item span4">
                    <h5>Family Information:</h5>
                </div>

                <div class="grid-item">
                    <label for="father_job">Father's Job:</label>
                    <span class="required">*</span>
                    <select id="father_job" name="father_job">
                        <option value="">Select Job</option>
                        <option value="teacher">Teacher</option>
                        <option value="doctor">Doctor</option>
                        <option value="engineer">Engineer</option>
                        <option value="farmer">Farmer</option>
                        <option value="businessman">Businessman</option>
                        <option value="driver">Driver</option>
                        <option value="lawyer">Lawyer</option>
                        <option value="nurse">Nurse</option>
                        <option value="mechanic">Mechanic</option>
                        <option value="architect">Architect</option>
                        <option value="scientist">Scientist</option>
                        <option value="artist">Artist</option>
                        <option value="chef">Chef</option>
                        <option value="journalist">Journalist</option>
                        <option value="technician">Technician</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="error-message" id="fatherJobError">Father's job is required.</div>
                </div>

                <div class="grid-item">
                    <label for="brother">Brother:</label>
                    <span class="required">*</span>
                    <input type="text" id="brother" name="brother">
                    <div class="error-message" id="brotherError">Brother name is required.</div>
                </div>

                <div class="grid-item">
                    <label for="uncle">Uncle(Paternal):</label>
                    <span class="required">*</span>
                    <input type="text" id="uncle" name="uncle">
                    <div class="error-message" id="uncleError">Uncle name is required.</div>
                </div>
                <div class="grid-item">
                    <label for="uncle">Uncle(Maternal):</label>
                    <span class="required">*</span>
                    <input type="text" id="uncle" name="uncle-2">
                    <div class="error-message" id="uncleError">Uncle name is required.</div>
                </div>

                <div class="grid-item">
                    <label for="uncles_son">Uncle's Son:</label>
                    <span class="required">*</span>
                    <input type="text" id="uncles_son" name="uncles_son">
                    <div class="error-message" id="unclesSonError">Uncle's son name is required.</div>
                </div>

                <div class="grid-item">
                    <label for="maternal_cousin">Maternal Cousin:</label>
                    <span class="required">*</span>
                    <input type="text" id="maternal_cousin" name="maternal_cousin">
                    <div class="error-message" id="maternalCousinError">Maternal Cousin name is required.</div>
                </div>

                <div class="grid-item span4">
                    <h5>Location Information:</h5>
                </div>

                <div class="grid-item">
                    <label for="province">Province:</label>
                    <span class="required">*</span>
                    <select id="province" name="province">
                        <option value="">Select Province</option>
                        <option value="Badakhshan">Badakhshan</option>
                        <option value="Badghis">Badghis</option>
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

                <div class="grid-item">
                    <label for="district">District:</label>
                    <span class="required">*</span>
                    <select id="district" name="district">
                        <option value="">Select District</option>
                    </select>
                    <div class="error-message" id="districtError">District is required.</div>
                </div>

                <div class="grid-item">
                    <label for="village">Village:</label>
                    <span class="required">*</span>
                    <input type="text" id="village" name="village">
                    <div class="error-message" id="maternalCousinError">village name is required.</div>
                </div>

                <div class="grid-item span4">
                    <label for="current_address">Current Address:</label>
                    <span class="required">*</span>
                    <textarea id="current_address" name="current_address"></textarea>
                    <div class="error-message" id="currentAddressError">Current address is required.</div>
                </div>

                <div class="grid-item span4">
                    <h5>Additional Information:</h5>
                </div>

                <div class="grid-item">
                    <label for="native_language">Native Language:</label>
                    <span class="required">*</span>
                    <select id="native_language" name="native_language">
                        <option value="">Select Language</option>
                        <option value="pashto">Pashto</option>
                        <option value="dari">Dari</option>
                        <option value="uzbek">Uzbek</option>
                        <option value="turkmen">Turkmen</option>
                        <option value="balochi">Balochi</option>
                        <option value="nuristani">Nuristani</option>
                        <option value="pashayi">Pashayi</option>
                        <option value="wakhi">Wakhi</option>
                        <option value="hindu">Hindu</option>
                    </select>
                    <div class="error-message" id="nativeLanguageError">Native language is required.</div>
                </div>

                <div class="grid-item">
                    <label for="class_id">Class:</label>
                    <span class="required">*</span>
                    <select id="class_id" name="class_id">
                        <option value="">Select Class</option>
                        <?php 
                        // Populate dropdown with filtered classes
                        if ($classes && count($classes) > 0) {
                            foreach ($classes as $class) {
                                echo "<option value='" . $class['id'] . "'>" . $class['class_name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No classes available</option>";
                        }
                        ?>
                    </select>
                    <div class="error-message" id="classIdError">Class ID is required.</div>
                </div>

                <div class="grid-item">
                    <label for="files">Photo:</label>
                    <input type="file" id="files" name="files">
                </div>

                <div class="grid-item">
                    <label for="doc">Document:</label>
                    <input type="file" id="doc" name="doc">
                </div>

                <div class="grid-item span4 last-row">
                    <input class="custom-btn" type="submit" value="Submit">
                </div>
            </form>
        </div>
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
        document.getElementById('studentForm').addEventListener('submit', function(event) {
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
                    id: 'grandfather_name',
                    errorId: 'grandfatherNameError'
                },
                {
                    id: 'gender',
                    errorId: 'genderError'
                },
                {
                    id: 'dob',
                    errorId: 'dobError'
                },
                {
                    id: 'age',
                    errorId: 'ageError'
                },
                {
                    id: 'tazkira_num',
                    errorId: 'tazkiraError'
                },
                {
                    id: 'tazkira_num',
                    errorId: 'tazkiraError'
                },
                {
                    id: 'asas_num',
                    errorId: 'asasNumError'
                },
                {
                    id: 'brother',
                    errorId: 'brotherError'
                },
                {
                    id: 'father_job',
                    errorId: 'fatherJobError'
                },
                {
                    id: 'uncle',
                    errorId: 'uncleError'
                },
                {
                    id: 'uncles_son',
                    errorId: 'unclesSonError'
                },
                {
                    id: 'maternal_cousin',
                    errorId: 'maternalCousinError'
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
                    id: 'current_address',
                    errorId: 'currentAddressError'
                },
                {
                    id: 'native_language',
                    errorId: 'nativeLanguageError'
                },
                {
                    id: 'status',
                    errorId: 'statusError'
                },
                {
                    id: 'class_id',
                    errorId: 'classIdError'
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