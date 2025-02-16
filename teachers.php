<?php 
// Include check_access.php to ensure access control
include('check_access.php');

// Use the user_id from the session, which is set in check_access.php
include('../includes/db_connection.php');
$user_id = $_SESSION['user_id'];

// Database connection parameters
$host = 'localhost';
$dbname = 'school';
$username = 'root';
$password = '';

try {
    // Establish database connection using PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    // Handle connection errors
    die("Connection failed: " . $e->getMessage());
}

// SQL query to fetch teacher details where staff_id matches the logged-in user
$sql = "SELECT 
            id,
            teacherName,
            password,
            role,
            lastname,
            father_name,
            gender,
            province,
            district,
            permanent_address,
            current_address,
            qualification,
            salary,
            subjects_taught,
            email,
            mobile,
            photo,
            created_at,
            staff_id
        FROM teachers 
        WHERE staff_id = :staff_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':staff_id', $user_id, PDO::PARAM_INT); // Bind the user_id as staff_id
$stmt->execute();

// Fetch all the matching results
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Start HTML output
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Details - Staff</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
        .no-results {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
        img {
            width: 100px; /* Adjust size of the photo if needed */
            height: auto;
        }
    </style>
    <title>Teachers</title>
</head>
<body>
    
<h2>Teacher Details Managed by You</h2>

<?php if ($result): ?>
    <!-- Table to display the teacher data -->
    <table>
        <thead>
            <tr>
                <th>Teacher Name</th>
                <th>Last Name</th>
                <th>Father Name</th>
                <th>Gender</th>
                <th>Province</th>
                <th>District</th>
                <th>Permanent Address</th>
                <th>Current Address</th>
                <th>Qualification</th>
                <th>Salary</th>
                <th>Subjects Taught</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Photo</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["teacherName"]); ?></td>
                    <td><?php echo htmlspecialchars($row["lastname"]); ?></td>
                    <td><?php echo htmlspecialchars($row["father_name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["gender"]); ?></td>
                    <td><?php echo htmlspecialchars($row["province"]); ?></td>
                    <td><?php echo htmlspecialchars($row["district"]); ?></td>
                    <td><?php echo htmlspecialchars($row["permanent_address"]); ?></td>
                    <td><?php echo htmlspecialchars($row["current_address"]); ?></td>
                    <td><?php echo htmlspecialchars($row["qualification"]); ?></td>
                    <td><?php echo htmlspecialchars($row["salary"]); ?></td>
                    <td><?php echo htmlspecialchars($row["subjects_taught"]); ?></td>
                    <td><?php echo htmlspecialchars($row["email"]); ?></td>
                    <td><?php echo htmlspecialchars($row["mobile"]); ?></td>
                    <td>
                        <?php if ($row["photo"]): ?>
                            <img src="uploads/<?php echo htmlspecialchars($row["photo"]); ?>" alt="Teacher Photo">
                        <?php else: ?>
                            No Photo Available
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <!-- If no teachers are found for the staff member -->
    <p class="no-results">No teachers found for this staff member.</p>
<?php endif; ?>

</body>
</html>

<?php
// Close database connection
$conn = null;
?>