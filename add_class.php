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
  $class = null;
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
      $class_id = $_GET['id'];

      // Fetch student data from the database
      $classQuery = "SELECT * FROM students WHERE id = ?";
      $classStmt = $conn->prepare($studentQuery);
      $classStmt->bind_param('i', $class_id);
      $classStmt->execute();
      $classResult = $classStmt->get_result();
      if ($classResult->num_rows > 0) {
          $class = $classResult->fetch_assoc();
      }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name = $_POST['className'];
    $grade_level = $_POST['grade_level'];
    $room_number = $_POST['room_number'];
    $students_amount = $_POST['students_amount'];
    $timing = $_POST['timing'];
    $enrolled_students = $_POST['enrolled_students'];
    $students_type = $_POST['students_type'];

        // Get the last inserted student ID and generate the new one
        $result = $conn->query("SELECT id FROM classes WHERE superadmin_id = '$superadmin_id' ORDER BY id DESC LIMIT 1");
        $lastClass = $result->fetch_assoc();
        $lastId = $lastClass ? $lastClass['id'] : '';

        $nextIdNumber = 1;
        if ($lastId) {
            $lastIdParts = explode('-', $lastId);
            if (isset($lastIdParts[2])) {
                $nextIdNumber = (int) $lastIdParts[2] + 1;
            }
        }
        $nextId = $school_prefix.'-'.$superadmin_id.'-CLS-'. str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
    $sql = "SELECT superadmin_id FROM staff WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($superadmin_id);
        if ($stmt->fetch()) {
            $stmt->close();
            $insert_sql = "INSERT INTO classes (id, class_name, grade_level, room_number, students_amount, timing, enrolled_students, students_type, staff_id, superadmin_id)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($insert_stmt = $conn->prepare($insert_sql)) {
                $insert_stmt->bind_param("sssssssssi", $nextId, $class_name, $grade_level, $room_number, $students_amount, $timing, $enrolled_students, $students_type, $user_id, $superadmin_id);

if ($insert_stmt->execute()) {
  echo "<p class='success'>New record created successfully</p>";
} else {
  echo "<p class='error'>Error: " . $insert_stmt->error . "</p>";
}


$insert_stmt->close();
            } else {
                echo "<p class='error'>Error preparing insert statement: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='error'>Error: No superadmin_id found for the logged-in user.</p>";
        }
        // $stmt->close();
    } else {
        echo "<p class='error'>Error preparing statement to fetch superadmin_id: " . $conn->error . "</p>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Insert Data into Class Table</title>
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
    .grid-item>input,
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
    .grid-item>input,
    button.custom-btn {
      height: 3rem;
    }

    .grid-item select:focus,
    .grid-item>input:focus,
    textarea:focus {
      border-color: black;
      outline: none;
    }

    input .grid-item select {
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

    .checkboxes {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      margin-top: 3%;
      margin-bottom: 15px;
    }

    .checkboxes input {
      accent-color: black;
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
      color: white;
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
      border: 1px solid red !important;
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
      <h2>Enter Class Data</h2>
      <form id="classForm" action="./add_class.php" method="POST">
        <div class="grid-item span4">
          <label for="className">Select Class:</label>
          <span class="required">*</span>
          <select name="className" id="className">
            <option value="">Select Class</option>
            <option value="first-A">first-A</option>
            <option value="first-B">first-B</option>
            <option value="first-C">first-C</option>
            <option value="Second-A">Second-A</option>
            <option value="Second-B">Second-B</option>
            <option value="Second-C">Second-C</option>
            <option value="Third-A">Third-A</option>
            <option value="Third-B">Third-B</option>
            <option value="Third-C">Third-C</option>
          </select>
          <div class="error-message" id="classNameError">Class is required.</div>
        </div>

        <div class="grid-item span4">
          <label for="Subjects">Select Subject:</label>
          <div class="checkboxes">
            <div class="span2">
              <input class="form-check-input" type="checkbox" name="subject[]" value="Islamic Eductions"> Islamic Eductions<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Holy Quran"> Holy Quran<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Dari"> Dari<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Pashto"> Pashto<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Skills"> Skills<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="History"> History<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="English"> English<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Geography"> Geography<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Islamic Teachings"> Islamic Teachings<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Tajweed"> Tajweed<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Tafseer"> Tafseer<br>
            </div>
            <div class="span2">
              <input class="form-check-input" type="checkbox" name="subject[]" value="Computer"> Computer<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Arabic"> Arabic<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Geology"> Geology<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Physics"> Physics<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Sociology"> Sociology<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Drawing"> Drawing<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="HandWriting"> HandWriting<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Science"> Science<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Profession"> Profession<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Biology"> Biology<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Chimestry"> Chimestry<br>
              <input class="form-check-input" type="checkbox" name="subject[]" value="Watan Dosti"> Watan Dosti<br>
            </div>
          </div>
        </div>

        <div class="grid-item span2">
          <label for="class_name">Class Name:</label>
          <span class="required">*</span>
          <select id="class_name" name="grade_level">
            <option value="">Select Class Grade</option>
            <option value="1st">1st</option>
            <option value="2nd">2nd</option>
            <option value="3rd">3rd</option>
            <option value="4th">4th</option>
            <option value="5th">5th</option>
            <option value="6th">6th</option>
            <option value="7th">7th</option>
            <option value="8th">8th</option>
            <option value="9th">9th</option>
            <option value="10th">10th</option>
            <option value="11th">11th</option>
            <option value="12th">12th</option>
          </select>
          <div class="error-message" id="class_NameError">Class name is required.</div>
        </div>

        <div class="grid-item span2">
          <label for="room_number">Room Number:</label>
          <span class="required">*</span>
          <select id="room_number" name="room_number">
            <option value="">Select Room</option>
            <option value="101">101</option>
            <option value="102">102</option>
            <option value="103">103</option>
            <option value="104">104</option>
            <option value="105">105</option>
            <option value="106">106</option>
            <option value="107">107</option>
            <option value="108">108</option>
            <option value="109">109</option>
            <option value="110">110</option>
            <option value="111">111</option>
            <option value="112">112</option>
          </select>
          <div class="error-message" id="roomNumberError">Room number is required.</div>
        </div>

        <div class="grid-item">
          <label for="students_amount">Total Students Amount:</label>
          <span class="required">*</span>
          <input type="number" id="students_amount" name="students_amount">
          <div class="error-message" id="studentsAmountError">Total students amount is required.</div>
        </div>

        <div class="grid-item">
          <label for="timing">Timing:</label>
          <span class="required">*</span>
          <select id="timing" name="timing">
            <option value="">Select Timing</option>
            <option value="AM-Morning">AM-Morning</option>
            <option value="PM-Afternoon">PM-Afternoon</option>
          </select>
          <div class="error-message" id="timingError">Timing is required.</div>
        </div>

        <div class="grid-item">
          <label for="enrolled_students">Enrolled Students:</label>
          <span class="required">*</span>
          <input type="number" id="enrolled_students" name="enrolled_students">
          <div class="error-message" id="enrolledStudentsError">Enrolled students is required.</div>
        </div>

        <div class="grid-item">
          <label for="students_type">Student Type:</label>
          <span class="required">*</span>
          <select id="students_type" name="students_type">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <div class="error-message" id="studentsTypeError">Student type is required.</div>
        </div>

        <div class="grid-item span4 last-row">
          <input class="custom-btn" type="submit" value="Submit">
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('classForm').addEventListener('submit', function(event) {
        let isValid = true;
        let firstEmptyField = null;

        const requiredFields = [{
            id: 'className',
            errorId: 'classNameError'
          },
          {
            id: 'class_name',
            errorId: 'class_NameError'
          },
          {
            id: 'room_number',
            errorId: 'roomNumberError'
          },
          {
            id: 'students_amount',
            errorId: 'studentsAmountError'
          },
          {
            id: 'timing',
            errorId: 'timingError'
          },
          {
            id: 'enrolled_students',
            errorId: 'enrolledStudentsError'
          },
          {
            id: 'students_type',
            errorId: 'studentsTypeError'
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
    });
  </script>

</body>

</html>