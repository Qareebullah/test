<?php
// session_start();
include('../includes/db_connection.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Documents</title>
    <style>
        .content-wrapper .container{
            min-width: 20vw;
            height: 85vh;
            background: #f5f5f5;
        }

        .top-title{
            text-align: center;
            margin-bottom: 20px;
        }
        #teacher-img{
            width: 30px;
            height: 30;
            border-radius: 50%;
        }
        h3{
             padding: 20px;
        }
    </style>
</head>
<body>
<div class="content-wrapper">
        <div class="container">
            <div class="top-title">
                <h3>All Related documents of School</h3><hr>
            </div>
        </div>
    </div>
</body>
</html>