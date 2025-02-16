<?php

// include('../includes/db_connection.php');

// Query to fetch customer data along with the staff name (JOIN query)
// $sql = "SELECT c.id, c.name, c.purpose, c.gender, c.mobile, c.create_At, c.staff_id, s.username 
//         FROM customers c
//         LEFT JOIN staff s ON c.staff_id = s.id";
// $result = $conn->query($sql);

// Fetch the results
// $customers = [];
// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         $customers[] = $row;
//     }
// } else {
//     $customers = [];
// }

// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Message</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f9;
            margin: 0;
            padding: 0;
            /* display: flex; */
            /* justify-content: center; */
            /* align-items: center; */
            height: 100vh;
            color: #333;
        }

        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            max-width: 1000px;
            text-align: center;
        }

        h1 {
            font-size: 2em;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            line-height: 1.5;
            color: #555;
        }

        .search-box {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            max-width: 300px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .footer {
            font-size: 0.9em;
            color: #888;
            margin-top: 20px;
        }

        .refresh-text {
            font-size: 0.8em;
            color: #888;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }

        a:hover {
            color: #388E3C;
        }
    </style>
    <script type="text/javascript">
        // Function to refresh the page every 30 seconds
        setTimeout(function(){
            location.reload();
        }, 30000); // 30000ms = 30 seconds

        // Function to filter the table based on the search query
        function searchReferral() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("referralTable");
            var tr = table.getElementsByTagName("tr");

            for (var i = 1; i < tr.length; i++) {
                var tdName = tr[i].getElementsByTagName("td")[1];
                var tdPurpose = tr[i].getElementsByTagName("td")[2];
                var tdStaff = tr[i].getElementsByTagName("td")[3];

                if (tdName || tdPurpose || tdStaff) {
                    var nameText = tdName.textContent || tdName.innerText;
                    var purposeText = tdPurpose.textContent || tdPurpose.innerText;
                    var staffText = tdStaff.textContent || tdStaff.innerText;

                    if (nameText.toLowerCase().indexOf(filter) > -1 || 
                        purposeText.toLowerCase().indexOf(filter) > -1 || 
                        staffText.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Referral Information</h1>
        <p>Here are the latest referrals:</p>
        
        <!-- Search Box -->
        <div class="search-box">
            <input type="text" id="searchInput" onkeyup="searchReferral()" placeholder="Search by name, purpose, or staff..." />
        </div>

        <!-- Table -->
        <table id="referralTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Purpose</th>
                    <th>Referred by Staff</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($customers) > 0): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['id']; ?></td>
                            <td><?php echo $customer['name']; ?></td>
                            <td><?php echo $customer['purpose']; ?></td>
                            <td><?php echo $customer['username']; ?></td>
                            <td>
                                <a href="add_student.php?id=<?php echo $customer['id']; ?>">[Edit]</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No referrals found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <p class="refresh-text">Page will refresh every 30 seconds.</p>
    </div>
</body>
</html>
