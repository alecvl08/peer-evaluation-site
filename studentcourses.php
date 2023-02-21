<?php
    session_start();
    require_once("db.php");
    $sql = "SELECT Course.Course_ID, Course_Name, Description, Professor.First_Name, Professor.Last_Name FROM Course INNER JOIN Enrollment ON Course.Course_ID = Enrollment.Course_ID LEFT JOIN Professor on Course.Professor_ID = Professor.Professor_ID WHERE Student_ID = ".$_SESSION['Student_ID'];
    $result = $mydb->query($sql);
?>
<!DOCTYPE html>
<html lang="en" style="background-color: #ededed">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="bulma.css"/>
        <title>My Courses</title>
    </head>
    <body>
        <section class="hero is-small" style="background-color: #0b2e6e">
            <div class="hero-body">
                <div class="columns is-vcentered is-centered">
                    <div class="column">
                        <a href="studentmenu.php">
                            <img src="smulogo.gif" style="height: 100px">
                        </a>
                        <p style="color: #bdaf18"><?php echo $_SESSION['Username']; ?></p>
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
        <h2 class="title is-2" style="text-align: center; font: arial; color: #0b2e6e">My Courses</h2>
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <table class="table is-hoverable is-scrollable" style="background-color: #d8edf3">
                <tr>
                    <th>Course ID</th>
                    <th>Course name</th>
                    <th>Description</th>
                    <th>Professor</th>
                    <th>View group</th>
                </tr>
                <?php
                    while($row=mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td>
                        <?php echo $row['Course_ID']; ?>
                    </td>
                    <td>
                        <?php echo $row['Course_Name']; ?>
                    </td>
                    <td>
                        <?php echo $row['Description']; ?>
                    </td>
                    <td>
                        <?php echo $row['First_Name']." ".$row['Last_Name'] ?>
                    </td>
                    <td>
                        <a href="studentgroup.php?courseID=<?php echo $row['Course_ID']; ?>">View group</a>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>