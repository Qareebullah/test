<?php

include('../includes/db_connection.php');
include('check_access.php');

$adminId = $user_id;


$query = "
    SELECT c.id, c.name, c.purpose, c.gender, c.mobile, c.create_At, c.staff_id 
    FROM customers c
    INNER JOIN staff s 
    ON c.staff_id = s.id
    WHERE s.superadmin_id = $adminId AND c.staff_id = s.id
";

$fetchCustomers = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <style>
      
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content-wrapper .container {
            min-width: 25vw;
            height: auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        table {
            font-size: 0.9rem;
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
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

        /* Modal styling */
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
            <h3>Customer Details</h3>
            <hr>
        </div>

        <?php if (mysqli_num_rows($fetchCustomers) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Purpose</th>
                        <th>Gender</th>
                        <th>Mobile</th>
                        <th>Created At</th>
                        <th>Staff ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($fetchCustomers)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['purpose']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['mobile']; ?></td>
                            <td><?php echo $row['create_At']; ?></td>
                            <td><?php echo $row['staff_id']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data" style="text-align: center; color: #888;">No customer data found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
