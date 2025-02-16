<?php
include('check_access.php');
include('../includes/db_connection.php');
$user_id = $_SESSION['user_id'];


if(isset($_GET['id'])){
    $id= $_GET['id'];
}
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./assets/css/backpage.css"> -->
    <title>خلص سوانح</title>

    <style>
        
*{
    margin: 0;
    padding: 0;
    /* box-sizing: border-box; */
}

.container{
    max-width: 800px;
    margin:0 auto;
}

/* Table Designs */
table{
    width: 100%;
    border-spacing: 0; 
}
table td, 
table th{
    border: 1px solid;
    font-size: 11px;
    padding: .2em;
    text-align: center;
}

table td{
    height: 1.3em;
}
table tr th{
    width: 20%;
}
.fw-bold{
    font-weight: bold;
}
.school-name{
    height: 40px;
}
.subject-exam-info th{
    text-align: start;
    height: 1.3em;
}
.subject-exam-info tr:nth-child(1) th{
    text-align: center;
    font-size: 1.2em;
}

.two-curve{
    position: relative;
    overflow: hidden;
    height: 20px;
    > .left{
        position: absolute;
        bottom: 0;
        right: 20px;
    }
    > .border{
       position:absolute;
       border: 1px slid black;
       right:0;
       background: black;
       width:100%; 
       transform: rotate(-10deg);
    }
    > .right{
        position: absolute;
        top:0;
        left: 20px;
    }
}

    </style>
</head>
<body dir="rtl">
    <br><br>
    <main>
        <div class="container first-section">
            <table class="table-subject">
                <tr>
                    <th colspan="15">نتیجه امتحانات متعلم</th>
                    <th colspan="2">ملاحظات</th>
                </tr>
                <tr>
                    <th class="school-name">اسم مکتب</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <th>سال ها</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <th class="two-curve">
                        <span class="left">مضامین</span>
                        <hr class="border">
                        <span class="right">صنوف</span>
                    </th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                <script>
                    let html = ``;
                    const subjects = ['قرآنکریم/تجوید/تفسیر','دنیات/فقه/عقاید','اسلامیات/احادیث','لسان اول','لسان دوم','لسان خارجی','عربی','ریاضیات','فزیک','ساینس/کیمیا','بیولوژی','جیودوزی/مهارت زندگی','تاریخ','اجتماعیات/جغرافیه','تعلیمات معدنی','حسن خط /کمپیوتر','معضمون انتخابی','حرفه','رسم/ هنر','کارهای عملی','تربیت بدنی','تهذیب',' ',' ','مجموعه','اوسط نمرات','نتیجه','درجه','ایام سال های تعلیمی','حاظر','غیرحاظر','مریض رخصت']
                    subjects.forEach(element => {
                        html += `
                            <tr>
                                <th>${element}</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="2"></td>
                            </tr>
                        `
                    });
                    document.write(html);
                </script>
                <tr>
                    <th>امضای نگران</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>امضای سرمعلم ومهر مکتب</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <table class="subject-exam-info">
                <tr>
                    <th colspan="2">توضیحات در مورد امحتان</th>
                </tr>
                <tr>
                    <th>اول</th>
                    <th>هفتم</th>
                </tr>
                <tr>
                    <th>دوم</th>
                    <th>هشتم</th>
                </tr>
                <tr>
                    <th>سوم</th>
                    <th>نهم</th>
                </tr>
                <tr>
                    <th>چهارم</th>
                    <th>دهم</th>
                </tr>
                <tr>
                    <th>پنجم</th>
                    <th>یازدهم</th>
                </tr>
                <tr>
                    <th>ششم</th>
                    <th>دوازدهم</th>
                </tr>
            </table>
           
        </div>
    </main>
    <br><br><br><br>
  
</body>
</html>