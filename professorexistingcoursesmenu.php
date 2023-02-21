<?php
    session_start();
    require_once("db.php");
    $sql = "SELECT Course_ID, Course_Name, Course_Term, Course_Year FROM Course WHERE Professor_ID = ".$_SESSION['Professor_ID'];
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
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <table class="table is-hoverable is-scrollable" style="background-color: #d8edf3">
                <tr>
                    <th>Course ID</th>
                    <th>Course name</th>
                    <th>Term</th>
                    <th>Year</th>
                    <th>Student groups and evaluations</th>
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
                        <?php echo $row['Course_Term']; ?>
                    </td>
                    <td>
                        <?php echo $row['Course_Year']; ?>
                    </td>
                    <td>
                        <a href="professorspecificcourse.php?courseID=<?php echo $row['Course_ID']; ?>">Student groups and evaluations</a>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>