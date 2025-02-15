<?php

include('check_access.php');
include('../includes/db_connection.php');

include('../includes/sidebar.php');

$sql = "SELECT Admin_id FROM information WHERE Admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);  
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows == 0) {
  
    include('school_inf.php');
} 

$conn->close();

?>

<style>
=======
?><style>

body {
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    height: 100vh;  
    margin: 0;  
}

.content-wrapper {
    margin-left: 170px; 
 
    flex-grow: 1; 
    margin-top: 60px; 
  
    width: calc(100% - 170px);  


    display: flex;
    flex-direction: column;
}

    overflow: hidden; 
    display: flex;
    flex-direction: column;
}


#dynamicContent {
  
    background-color: #f9f9f9; 
    border-radius: 8px;
    box-sizing: border-box;
    width: 100%;  
    height: 100%;  
    flex-grow: 1;  
    overflow: hidden; 
    text-overflow: ellipsis; 
    white-space: nowrap; 
}

#defaultContent {
    padding: 20px;
    background-color: #fff;
    box-sizing: border-box;
    max-width: 100%;
}


#defaultContent, #dynamicContent {
    word-wrap: break-word; 
    overflow-wrap: break-word; 
    text-overflow: ellipsis; 
}


#dynamicContent > * {
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<div class="content-wrapper">

    <div id="defaultContent">
        <h1>Welcome to the Dashboard</h1>
        <p>This is your SuperAdmin Dashboard content.</p>
    </div>

    <div id="dynamicContent"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   
    $('a[id^="sidebarButton"]').on('click', function(e) {
        e.preventDefault(); 
        
        var targetPage = $(this).data('target');  

    
        $('#defaultContent').hide();
        
       
        $.ajax({
            url: targetPage, 
            method: 'GET',
            success: function(response) {
            
                $('#dynamicContent').html(response);
            },
            error: function() {
                alert('An error occurred while loading the content.');
            }
        });
    });


    $(document).on('click', '#sidebarButtonManageStaff, #sidebarButtonMyTeachers, #sidebarButtonMyClasses, #sidebarButtonMyStudents, #sidebarButtonManageDocuments, #sidebarButtonManageFinance, #sidebarButtonSettings, #sidebarButtonReports, #sidebarButtonAboutUs', function(e) {
        e.preventDefault();
        
        var targetPage = $(this).data('target');  

      
        $('#defaultContent').hide();

        $.ajax({
            url: targetPage,  
            method: 'GET',
            success: function(response) {
             
                $('#dynamicContent').html(response);
            },
            error: function() {
                alert('An error occurred while loading the content.');
            }
        });
    });
</script>
