<?php

include('../includes/db_connection.php'); 
include('check_access.php'); 

$adminId = $user_id;


$today = new DateTime();
$currentMonthStart = new DateTime('first day of this month');
$currentMonthEnd = new DateTime('last day of this month');


function getReport($period, $adminId, $conn, $selectedMonth = null) {
    global $today, $currentMonthStart, $currentMonthEnd;  


    $selectedMonthDate = DateTime::createFromFormat('Y-m', $selectedMonth);

    if ($selectedMonthDate > $today) {
        return "No data available for future months.";
    }

    
    if ($period == 'daily') {
        if ($selectedMonthDate == $today) {
          
            $query = "
                SELECT COUNT(*) AS customer_count, DATE(customers.create_at) AS date
                FROM customers
                JOIN staff ON customers.staff_id = staff.id
                WHERE customers.create_at BETWEEN ? AND ? 
                AND staff.superadmin_id = ? 
                GROUP BY DATE(customers.create_at)";
            
            $stmt = $conn->prepare($query);
            if ($stmt === false) {
                die('Error preparing query: ' . $conn->error);
            }
            $stmt->bind_param("sss", $currentMonthStart->format('Y-m-d'), $currentMonthEnd->format('Y-m-d'), $adminId);
        } else {
          
            $startOfMonth = $selectedMonthDate->format('Y-m-01');
            $endOfMonth = $selectedMonthDate->modify('first day of next month')->format('Y-m-d');
            
            $query = "
                SELECT COUNT(*) AS customer_count, DATE(customers.create_at) AS date
                FROM customers
                JOIN staff ON customers.staff_id = staff.id
                WHERE customers.create_at >= ? AND customers.create_at < ? 
                AND staff.superadmin_id = ? 
                GROUP BY DATE(customers.create_at)";
            
            $stmt = $conn->prepare($query);
            if ($stmt === false) {
                die('Error preparing query: ' . $conn->error);
            }
            $stmt->bind_param("sss", $startOfMonth, $endOfMonth, $adminId);
        }

     
        $stmt->execute();
        $result = $stmt->get_result();

        if ($selectedMonthDate == $today) {
   
            $customerCount = 0;
            while ($row = $result->fetch_assoc()) {
                $customerCount += $row['customer_count'];
            }
            return $customerCount;
        } else {
          
            $totalCount = 0;
            $daysCount = 0;
            while ($row = $result->fetch_assoc()) {
                $totalCount += $row['customer_count'];
                $daysCount++;
            }
            return ($daysCount > 0) ? round($totalCount / $daysCount) : 0;
        }
    } elseif ($period == 'weekly') {
        if ($selectedMonthDate == $today) {
        
            $query = "
                SELECT COUNT(*) AS customer_count, WEEK(customers.create_at) AS week
                FROM customers
                JOIN staff ON customers.staff_id = staff.id
                WHERE customers.create_at BETWEEN ? AND ? 
                AND staff.superadmin_id = ? 
                GROUP BY WEEK(customers.create_at)";
            
            $stmt = $conn->prepare($query);
            if ($stmt === false) {
                die('Error preparing query: ' . $conn->error);
            }
            $stmt->bind_param("sss", $currentMonthStart->format('Y-m-d'), $currentMonthEnd->format('Y-m-d'), $adminId);
        } else {
      
            $startOfMonth = $selectedMonthDate->format('Y-m-01');
            $endOfMonth = $selectedMonthDate->modify('first day of next month')->format('Y-m-d');
            
            $query = "
                SELECT COUNT(*) AS customer_count, WEEK(customers.create_at) AS week
                FROM customers
                JOIN staff ON customers.staff_id = staff.id
                WHERE customers.create_at >= ? AND customers.create_at < ? 
                AND staff.superadmin_id = ? 
                GROUP BY WEEK(customers.create_at)";
            
            $stmt = $conn->prepare($query);
            if ($stmt === false) {
                die('Error preparing query: ' . $conn->error);
            }
            $stmt->bind_param("sss", $startOfMonth, $endOfMonth, $adminId);
        }

   
        $stmt->execute();
        $result = $stmt->get_result();

        if ($selectedMonthDate == $today) {
       
            $customerCount = 0;
            while ($row = $result->fetch_assoc()) {
                $customerCount += $row['customer_count'];
            }
            return $customerCount;
        } else {
       
            $totalCount = 0;
            $weeksCount = 0;
            while ($row = $result->fetch_assoc()) {
                $totalCount += $row['customer_count'];
                $weeksCount++;
            }
            return ($weeksCount > 0) ? round($totalCount / $weeksCount) : 0;
        }
    } elseif ($period == 'monthly') {
    
        $startOfMonth = $selectedMonthDate->format('Y-m-01');
        $endOfMonth = $selectedMonthDate->modify('first day of next month')->format('Y-m-d');
        
        $query = "
            SELECT COUNT(*) AS customer_count
            FROM customers
            JOIN staff ON customers.staff_id = staff.id
            WHERE customers.create_at >= ? AND customers.create_at < ? 
            AND staff.superadmin_id = ?";
        
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Error preparing query: ' . $conn->error);
        }
        $stmt->bind_param("sss", $startOfMonth, $endOfMonth, $adminId);

        
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        return $row['customer_count'];
    } else {
        return "Invalid period selected";
    }
}


$period = isset($_POST['period']) ? $_POST['period'] : 'daily'; 


$selectedMonth = isset($_POST['month']) ? $_POST['month'] : $today->format('Y-m'); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Report</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 40px 20px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 36px;
        }
        h2 {
            text-align: center;
            color: #34495e;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #bdc3c7;
        }
        th, td {
            padding: 12px;
            text-align: center;
            font-size: 18px;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        td {
            background-color: #ecf0f1;
        }
        tr:hover td {
            background-color: #dfe6e9;
        }
        button, select {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            margin: 10px 5px;
            font-size: 16px;
        }
        button:hover, select:hover {
            background-color: #2980b9;
        }
        select {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h1>Customer Report</h1>

   
    <form method="post" action="" style="text-align: center;">
        <select name="month">
            <?php
           
                for ($i = 1; $i <= 12; $i++) {
                 
                    $tempDate = new DateTime();
                    $tempDate->setDate($today->format('Y'), $i, 1); 
                    $monthValue = $tempDate->format('Y-m'); 
                    echo "<option value='$monthValue'" . ($selectedMonth == $monthValue ? " selected" : "") . ">" . $tempDate->format('F Y') . "</option>";
                }
            ?>
        </select>
        <br>
        <button type="submit" name="period" value="daily">Daily Report</button>
        <button type="submit" name="period" value="weekly">Weekly Report</button>
        <button type="submit" name="period" value="monthly">Monthly Report</button>
    </form>


    <h2>Selected Report: <?php echo ucfirst($period); ?></h2>
    <table>
        <thead>
            <tr>
                <th>Period</th>
                <th>Customer Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo ucfirst($period); ?> Report</td>
                <td><?php echo getReport($period, $adminId, $conn, $selectedMonth); ?></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
