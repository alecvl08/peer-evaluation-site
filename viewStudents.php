<!doctype html>
<html lang="en" style="background-color: #ededed">
    <head>
    <title>View Students</title>
    </head>
    <body>
        <?php
            $id = 0;
            if(isset($_GET['id'])) {
                $id=$_GET['id'];

                require_once("db.php");

                $sql="SELECT First_Name, Last_Name FROM Student INNER JOIN Enrollment ON Student.Student_ID = Enrollment.Student_ID WHERE Course_ID =".$id;
                $result = $mydb->query($sql);
                if ($result) {
                    $num_rows = mysqli_num_rows($result);
                    if ($num_rows > 0) {
                        echo "<h3 class='title is-3' style='font: arial; color: #0b2e6e; text-align: center'>Students</h3>
                            <table class='table is-bordered is-hoverable' style='background-color: #d8edf3'>
                                <tr>
                                    <th>First</th>
                                    <th>Last</th>
                                </tr>";
                        while ($row=mysqli_fetch_array($result)) {
                            echo "<tr>
                                    <td>".$row['First_Name']."</td>
                                    <td>".$row['Last_Name']."</td>
                                </tr>";
                        }
                        echo "</table>";
                    }
                    else {
                        echo "No students enrolled";
                    }
                }
            }
        ?>
    </body>
</html>