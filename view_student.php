<?php

include('check_access.php');
include('../includes/db_connection.php');
$user_id = $_SESSION['user_id'];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $student_id = $_GET['id'];

    $fetchRecord = "SELECT * FROM students INNER JOIN classes ON students.class_id = classes.id WHERE students.id = '$student_id'";
    $result = $conn->query($fetchRecord);
}  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خلص سوانح</title>

    <style>
        *{
            margin: 0;
            padding: 0;
            /* box-sizing: border-box; */
        }

        .container{
            max-width: 850px;
            margin:0 auto;
        }
        .container-fluid{
            max-width:1450px;
            margin:0 auto;
        }

        .header{
            display: flex;
            justify-content: space-between;
            gap: 1em;
            height: 180px;
            align-items: center;
            padding: 0 1em;
        }
        main{
            border: 1px solid;
        }

        .header .left-image, 
        .header .right-image{
            width: 25%;
            > img{
                width: 100%;
            }
        }
        .header .main-content{
            display: flex;
            width: 100%;
            flex-direction: column;
            align-items: center;
            > h1{
                font-size: 1.2em;
            }
        }

        /* Table Designs */
        table{
            width: 100%;
            border-spacing: 0;
        }
        table td, 
        table th{
            border: 1px solid;
            font-size: .6em;
            padding: .2em;
            text-align: center;
        }
        .fw-bold{
            font-weight: bold;
        }

        /* /////////////////////////////////// */
        /* First row tables  */
        .first-table-row,
        .third-table-row{
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 3em;
        }


        .first-table-row table td{
            font-weight: bold;
            height: 3.5em;
        }
        .left table th, 
        .left table td{
            width: calc(100%/3);
        } 
        .first-table-row .student-more-info table tr td
        {
            height: 1em;
        }
        .first-table-row .student-more-info table tr:nth-child(1){
            width: 50%;
        }
        .row-data{
            width: 100%;
            > td{
                width: 40%
            }
        }
        .profile-img{
            width: 120px;
        }

        /* /////////////////////////////////// */
        /* second row tables  */
        .second-row{
            border: 1px solid;
            padding:.4em;
            font-size: .8em;
            margin: .2em 0;
        }

        /* /////////////////////////////////// */
        /* third row tables  */
        .third-table-row .right td{
            height: 1.3em;
        }
        .third-table-row .fire-student td{
            width: 80%;
        }
        /* /////////////////////////////////// */
        /* fourth row tables  */
        .fourth-table-row table tr{
            font-size: 1.3em;
            > th{
                width: calc(100%/8);
            }
            > td{
                height: 1.1em;
            }
            > .w-70{
                width: 70%;
            }
        }
        .fourth-table-row .classes tr td:nth-child(1){
            font-weight: bold;
        } 



    </style>
    
</head>
<body dir="rtl">
    <header class="container">
        <div class="header">
            <div class="left-image">
                <img src="./images/Islamic-Afghanistan.jpg" alt="Islamic-republic-of-afghanistan">
            </div>
            <div class="main-content">
                <h1>امارت اسلامی افغانستان</h1>
                <h1>وزارت معارف</h1>
                <h1>ریاست معارف  (شهر کابل)</h1>
                <h1>مدیرت مکاتب (لیسه الوالقاسم فردوسی)</h1>
                <h1>کارت سوانح متعلمین</h1>
            </div>
            <div class="right-image">
                <img src="./images/Ministry-of-Education.png" alt="Ministry-of-education">
            </div>
        </div>
    </header>
    <!-- Front Page -->
    <main class="container">
        <!-- start first table row -->
        <?php foreach($result as $row){?>
            <div class="first-table-row" >
                <div class="left">
                    <div class="student-info-dari">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="3">فهرست متعلم</th>
                                </tr>
                                <tr>
                                    <th>نام</th>
                                    <th>تخلص</th>
                                    <th>نام پدر</th>
                                    <th>نام پدر کلان</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['lastname']; ?></td>
                                    <td><?php echo $row['father_name']; ?></td>
                                    <td><?php echo $row['grandfather_name']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="student-info-english">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="3">فهرست متعلم به انگلیسی بر اساس تذکره تابعیت</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>Father Name</th>
                                    <th>Grand Father</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['lastname']; ?></td>
                                    <td><?php echo $row['father_name']; ?></td>
                                    <td><?php echo $row['grandfather_name']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="right">
                    <div class="student-more-info">
                        <table>
                            <tr>
                                <th colspan="2"> معلومات در مورد پدر متعلم</th>
                                <th class="profile-img" rowspan="9"><img src="./images/<?php echo $row['photo']; ?>" width="50px" height="50px" alt="student image"></th>
                            </tr>
                            <tr class="row-data">
                                <th>محل بودوباش</th>
                                <td><?php echo $row['current_Address']; ?></td>
                            </tr>
                            <tr>
                                <th>وظیفه</th>
                                <td><?php echo $row['father_job']; ?></td>
                            </tr>
                            <tr>
                                <th>نمبر تلیفون</th>
                                <td><?php echo $row['mobile']; ?></td>
                            </tr>
                            <tr>
                                <th>نمبر مبایل</th>
                                <td><?php echo $row['mobile']; ?></td>
                            </tr>
                            <tr>
                                <th>نمبراشخاص خانه متعلم</th>
                                <td><?php echo $row['mobile']; ?></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end first table row -->
            
            <!-- start second table row -->
            <div class="second-row">
                <p>توضیحات درصورت اصلاح شهرت</p>
            </div>
            <!-- end second table row -->

            <!-- start third table row -->
            <div class="third-table-row" >
                <div class="left">
                    <table>
                        <!-- سکونت اصلی -->
                        <tr>
                            <th colspan="3">سکونت اصلی</th>
                        </tr>
                        <tr>
                            <th>ولایت</th>
                            <th>ولسوالی/ناحیه</th>
                            <th>قریه/گذر</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['province']; ?></td>
                            <td><?php echo $row['district']; ?></td>
                            <td><?php echo $row['village']; ?></td>
                        </tr>
                        <!-- سکونت فعلی -->
                        <tr>
                            <th colspan="3">سکونت فعلی</th>
                        </tr>
                        <tr>
                            <th>ولایت</th>
                            <th>ولسوالی/ناحیه</th>
                            <th>قریه/گذر</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['current_Address']; ?></td>
                            
                        </tr>
                        <!-- ذکره متعلم -->
                        <tr>
                            <th colspan="3"> نمبر تذکره متعلم</th>
                        </tr>
                        <tr>
                            <th>نمبر</th>
                            <th>صفحه</th>
                            <th>جلد</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['tazkira_num']; ?></td>
                            <td><?php echo $row['page_num']; ?></td>
                            <td><?php echo $row['cover_num']; ?></td>
                        </tr>
                        
                    </table>
                    <table>
                        <!-- تولد -->
                        <tr>
                            <th colspan="4">تاریخ تولد متعلم</th>
                        </tr>
                        <tr>
                            <th>روز</th>
                            <th>ماه</th>
                            <th colspan="2">سال</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>12</td>
                            <td>1400</td>
                            <td class="fw-bold">شمسی</td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td>7</td>
                            <td><?php echo $row['dob']; ?></td>
                            <td class="fw-bold">میلادی</td>
                        </tr>
                    </table>
                    <table>
                        <!-- زبان -->
                        <tr>
                            <th colspan="3">زبان مادری</th>
                        </tr>
                        <tr>
                            <th><?php echo $row['native_language']; ?></th>
                        </tr>
                        
                    </table>
                </div>
                <div class="right">
                    <table>
                        <tr>
                            <th colspan="5">شمولیت نمبر اساس متعلم درمکاتب</th>
                        </tr>
                        <tr>
                            <th>نام مکتب</th>
                            <th>نمبر اساس</th>
                            <th>صنف</th>
                            <th>تاریخ</th>
                            <th>نمبر مکتوب</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php echo $row['asas_num'];?></td>
                            <td><?php echo $row['grade_level'];?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table class="fire-student">
                        <tr>
                            <th colspan="2">منفک شدن متعلم</th>
                        </tr>
                        <tr>
                            <th>تاریخ</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>نمبرمکتوب</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>صنف</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>علت</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>جریمه</th>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- end third table row -->

            <!-- start fourth table row -->
            <div class="fourth-table-row" >
                <table>
                    <tr>
                        <th colspan="8">اقارب نزدیک متعلم</th>
                    </tr>
                    <tr>
                        <th>برادر</th>
                        <th>کاکا</th>
                        <th>ماما</th>
                        <th>پسر کاکا</th>
                        <th>پسرماما</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><?php echo $row['brother'];?> </td>
                        <td><?php echo $row['uncle'];?></td>
                        <td><?php echo $row['mama'];?></td>
                        <td><?php echo $row['uncles_son'];?></td>
                        <td><?php echo $row['maternal_cousin'];?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <table class="classes">
                    <tr>
                        <th colspan="3">نظریات نگران صنف/اداره مکتب در مورد متعمل</th>
                    </tr>
                    <tr>
                        <th>صنف</th>
                        <th>اسم نگران</th>
                        <th class="w-70">نظریات</th>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td><?php $row['grade_level'];?></td>
                        <td><?php $row['teacherName'];?></td>
                        <td><?php $row['caretaker_comment'];?></td>
                    </tr>
                    <tr>
                        <td>وضع صحی</td>
                        <td><?php $row['student_health'];?></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <!-- end fourth table row -->
        <?php } ?>     
    </main>
  
</body>
</html>