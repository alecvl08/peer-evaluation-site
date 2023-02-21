<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" style="background-color: #ededed">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="bulma.css"/>
        <script src="jquery-3.1.1.min.js"></script>
        <title>Import students and courses</title>
        <script>
            $(function(){
                $(".view-students").on('click', function() {
                    var element = $(this);
                    var id = element.attr("id");
                    $.ajax({
                        url:"viewStudents.php?id="+id,
                        async:true,
                        success: function(result){
                            $("#studentsTable").html(result);
                        }
                    })
                });
            })
        </script>
    </head>
    <body>
        <section class="hero is-small" style="background-color: #0b2e6e">
            <div class="hero-body">
                <div class="columns is-vcentered is-centered">
                    <div class="column">
                        <a href="professormenu.php">
                            <img src="smulogo.gif" style="height: 100px">
                            <p style="color: #bdaf18"><?php echo $_SESSION['Username']; ?></p>
                        </a>
                    </div>
                    <div class="column" style="text-align: center">
                        <h1 class="title is-1" style="font: arial; color: #bdaf18">SMU Evaluations</h1>
                    </div>
                    <div class="column" style="text-align: right">
                        <a href="login.php">
                            <button class="button">Logout</button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <h2 class="title is-2" style="text-align: center; font: arial; color: #0b2e6e">Import Courses and Students</h2>
        
        <nav class="level m-4">
            <div class="level-left">
                <div class="level-item">
                    <a href="SMU import template.xlsx">
                        <button>Download Excel Template</button>
                    </a>
                </div>
                <div class="level-item">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                        <label for="uploadFile">Upload Excel file</label>
                        <input type="file" name="uploadFile" accept=".xlsx">
                        <input type="submit" name="submit">
                    </form>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <label for="deleteAll">Delete all courses, students, and enrollments</label>
                        <input type="submit" name="deleteAll">
                    </form>
                </div>
            </div>
        </nav>
        <?php
            include("db.php");
            if (isset($_POST['submit'])) {
                if (isset($_FILES['uploadFile'])) {
                    $uploadFile = $_FILES['uploadFile']['tmp_name'];
                    require 'PHPExcel-1.8/Classes/PHPExcel.php';
                    $excel = PHPExcel_IOFactory::load($uploadFile);
                    $excel->setActiveSheetIndex(0);
                    $i = 2;

                    while($excel->getActiveSheet()->getCell('A'.$i)->getValue() != "") { //watch for 0s it thinks it's blank
                        $course_ID = $excel->getActiveSheet()->getCell('A'.$i)->getValue();
                        $course_name = $excel->getActiveSheet()->getCell('B'.$i)->getValue();
                        $description = $excel->getActiveSheet()->getCell('C'.$i)->getValue();
                        $professor_ID = $excel->getActiveSheet()->getCell('D'.$i)->getValue();
                        $course_year = $excel->getActiveSheet()->getCell('E'.$i)->getValue();
                        $course_term = $excel->getActiveSheet()->getCell('F'.$i)->getValue();
                        $i++;

                        $sql = $mydb->dbConn->prepare("insert into DBTeam4.Course(Course_ID, Course_Name, Description, Professor_ID, Course_Year, Course_Term)
                        values (?, ?, ?, ?, ?, ?)");
                        $sql->bind_param('issiis', $course_ID, $course_name, $description, $professor_ID, $course_year, $course_term);
                        $result = $sql->execute();
                        if(!$result) {
                            echo "<script>alert('Database error: Possible duplicate rows. Use the Delete all courses, students, and enrollments button before importing')</script>";
                        }
                    }
                    $excel->setActiveSheetIndex(1);
                    $i = 2;
                    while($excel->getActiveSheet()->getCell('A'.$i)->getValue() != "") {
                        $Student_ID = $excel->getActiveSheet()->getCell('A'.$i)->getValue();
                        $First_Name = $excel->getActiveSheet()->getCell('B'.$i)->getValue();
                        $Last_Name = $excel->getActiveSheet()->getCell('C'.$i)->getValue();
                        $username = $excel->getActiveSheet()->getCell('D'.$i)->getValue();
                        $password = $excel->getActiveSheet()->getCell('E'.$i)->getValue();
                        $email = $excel->getActiveSheet()->getCell('F'.$i)->getValue();
                        $i++;

                        $sql = $mydb->dbConn->prepare("insert into DBTeam4.Student(Student_ID, First_Name, Last_Name, Username, Password, Email_Address)
                        values (?, ?, ?, ?, ?, ?)");
                        $sql->bind_param('isssss', $Student_ID, $First_Name, $Last_Name, $username, $password, $email);
                        $result = $sql->execute();
                        if(!$result) {
                            echo "<script>alert('Database error: Possible duplicate rows. Use the Delete all courses, students, and enrollments button before importing')</script>";
                        }
                    }

                    $excel->setActiveSheetIndex(2);
                    $i = 2;
                    while($excel->getActiveSheet()->getCell('A'.$i)->getValue() != "") {
                        $Enrollment_Course_ID = $excel->getActiveSheet()->getCell('A'.$i)->getValue();
                        $Enrollment_Student_ID = $excel->getActiveSheet()->getCell('B'.$i)->getValue();
                        $i++;

                        $sql = $mydb->dbConn->prepare("insert into DBTeam4.Enrollment(Course_ID, Student_ID)
                        values (?, ?)");
                        $sql->bind_param('ii', $Enrollment_Course_ID, $Enrollment_Student_ID);
                        $result = $sql->execute();
                        if(!$result) {
                            echo "<script>alert(Database error: Possible duplicate rows. Use the Delete all courses, students, and enrollments button before importing')</script>";
                        }
                    }
        ?>
        <div class="columns is-centered m-6">
            <div class="column is-three-quarters">
                <h3 class="title is-3" style="font: arial; color: #0b2e6e; text-align: center">Courses</h3>
                <div class="table-container">
                    <table class="table is-bordered is-hoverable" style="background-color: #d8edf3">
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <!-- <th>Description</th> -->
                            <th>Professor First Name</th>
                            <th>Professor Last Name</th>
                            <th>Year</th>
                            <th>Term</th>
                            <th>View Students</th>
                        </tr>
        <?php
                    $sql = "SELECT Course_ID, Course_Name, Description, Course.Professor_ID, Professor.First_Name, Professor.Last_Name, Course_Year, Course_Term
                    FROM Course
                    LEFT JOIN Professor ON Course.Professor_ID = Professor.Professor_ID;";
                    $result = $mydb->query($sql);

                    while($row=mysqli_fetch_array($result)) {
        ?>
                        <tr>
                            <td>
                                <?php echo $row['Course_ID']; ?>
                            </td>
                            <td>
                                <?php echo $row['Course_Name']; ?>
                            </td>
                            <!-- <td>
                                <?php //echo $row['Description']; ?>
                            </td> -->
                            <td>
                                <?php echo $row['First_Name']; ?>
                            </td>
                            <td>
                                <?php echo $row['Last_Name']; ?>
                            </td>
                            <td>
                                <?php echo $row['Course_Year']; ?>
                            </td>
                            <td>
                                <?php echo $row['Course_Term']; ?>
                            </td>
                            <td>
                                <button style="background-color: #0b2e6e; color: #bdaf18" id="<?php echo $row['Course_ID']; ?>" class="view-students button">View Students</button>
                            </td>
                        </tr>
        <?php
                    }
        ?>
                    </table>
                </div>
            </div>
            <div class="column is-one-quarter">
                <div id="studentsTable">
                    
                </div>
            </div>
        </div>
        <?php
                }
            }
            if (isset($_POST['deleteAll'])) {
                $sql = "DELETE FROM Course";
                $result = $mydb->query($sql);
                $sql = "DELETE FROM Student";
                $result = $mydb->query($sql);
                $sql = "DELETE FROM Enrollment";
                $result = $mydb->query($sql);
                header("Refresh:0");
            }
        ?>
    </body>
</html>