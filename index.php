<?php
include('header.php');
include('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            color: #333;
        }

        #content {
            padding: 20px;
            /* margin-left: 270px; */
            /* To make space for sidebar */
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        .dashboard-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .stat-title {
            font-size: 22px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
            color: #2980b9;
        }

        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div id="content">
        <div class="container">

            <!-- Main content area where dynamic content will be loaded -->
            <div id="main-content">
                <h1 class="dashboard-title">Dashboard</h1>
                <p>Welcome to the Dashboard! Please select an option from the sidebar to view content.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Function to load page content into the main content area
        function loadPageContent(pageUrl) {
            $.ajax({
                url: pageUrl,
                type: 'GET',
                success: function(response) {
                    $('#main-content').html(response);
                },
                error: function() {
                    $('#main-content').html('<p>Error loading page.</p>');
                }
            });
        }

        // Sidebar click event listener
        $(document).ready(function() {
            $('#sidebar a').on('click', function(e) {
                e.preventDefault(); // Prevent default action (navigation)

                var pageUrl = $(this).attr('href'); // Get the link's href (the page URL)
                loadPageContent(pageUrl); // Load the content dynamically
            });
        });
    </script>

</body>

</html>