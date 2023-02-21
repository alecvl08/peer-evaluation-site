<?php
    session_start();
    require_once("db.php");
    date_default_timezone_set('EST');

    //Gets list of students in this group
    $groupMembersSql = "SELECT Student.Student_ID, First_Name, Last_Name FROM Student
    INNER JOIN Group_Membership ON Student.Student_ID = Group_Membership.Student_ID
    WHERE Group_ID = (SELECT Group.Group_ID FROM DBTeam4.Group
    INNER JOIN Group_Membership ON Group.Group_ID = Group_Membership.Group_ID
    INNER JOIN Course ON Group.Course_ID = Course.Course_ID
    WHERE Student_ID = ".$_SESSION['Student_ID']." AND Course.Course_ID = ".$_GET['courseID'].");";
    $groupMembersResult = $mydb->query($groupMembersSql);

    //Gets this group's ID and name
    $groupSql = "SELECT Group.Group_ID, Group_Name FROM DBTeam4.Group
    INNER JOIN Group_Membership ON Group.Group_ID = Group_Membership.Group_ID
    INNER JOIN Course ON Group.Course_ID = Course.Course_ID
    WHERE Student_ID = ".$_SESSION['Student_ID']." AND Course.Course_ID = ".$_GET['courseID'].";";
    $groupResult = $mydb->query($groupSql);

    //Gets this course's evaluation start and end dates
    $datesSql = "SELECT Course_Eval_StartDate, Course_Eval_EndDate FROM Course WHERE Course_ID = ".$_GET['courseID'].";";
    $datesResult = $mydb->query($datesSql);
    $datesRow = mysqli_fetch_array($datesResult);

?>
<!DOCTYPE html>
<html lang="en" style="background-color: #ededed">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="bulma.css"/>
        <title>Group</title>
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
        <?php
            while ($groupRow = mysqli_fetch_array($groupResult)) {
                $groupName = $groupRow['Group_Name'];
                $groupID = $groupRow['Group_ID'];
        ?>
            <h3 class="title is-3"style="text-align: center; font: arial; color: #0b2e6e">Group name: <?php echo $groupName; ?></h1>
        <?php
                if (date("Y-m-d") >= $datesRow['Course_Eval_StartDate'] && date("Y-m-d") <= $datesRow['Course_Eval_EndDate']) {
        ?>
            <h5 class="title is-5" style="text-align: center; font: arial; color: #0b2e6e">
                Evaluations are due <?php echo $datesRow['Course_Eval_EndDate']; ?>
            </h5>
        <?php
                }
                if (date("Y-m-d") > $datesRow['Course_Eval_EndDate']) {
        ?>
            <h5 class="title is-5" style="text-align: center; font: arial; color: #0b2e6e">Evaluations are closed</h5>
        <?php
                }
                if (date("Y-m-d") < $datesRow['Course_Eval_StartDate']) {
        ?>
            <h4 class="title is-4" style="text-align: center">
                Peer evaluations will open on <?php echo $datesRow['Course_Eval_StartDate']; ?>
            </h4>
        <?php
                }
            }
        ?>
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <table class="table is-hoverable is-scrollable" style="background-color: #d8edf3">
                <tr>
                    <th>Group member name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                <?php
                    while ($row=mysqli_fetch_array($groupMembersResult)) {
                ?>
                <tr>
                    <td>
                        <?php echo $row['First_Name']." ".$row['Last_Name']; ?>
                    </td>
                    <td>
                        <?php
                            $evalsSql = "SELECT Peer_Evaluation_ID FROM Peer_Evaluation WHERE Student_ID = ".$_SESSION['Student_ID']." AND Evaluated_Student_ID = ".$row['Student_ID']." AND Group_ID = ".$groupID;
                            $evalsResult = $mydb->query($evalsSql);
                            if(mysqli_num_rows($evalsResult) >= 1) {
                                echo "Completed";
                            }
                            else echo "Incomplete";
                        ?>
                    </td>
                    <td>
                        <?php
                            if(mysqli_num_rows($evalsResult) == 0 && 
                                date("Y-m-d") >= $datesRow['Course_Eval_StartDate'] && 
                                date("Y-m-d") <= $datesRow['Course_Eval_EndDate']) {
                        ?>
                                <a href="studentevalform.php?groupID=<?php echo $groupID; ?>&studentID=<?php echo $row['Student_ID']; ?>&courseID=<?php echo $_GET['courseID']; ?>">
                                    <button class="button is-small" style="background-color: #0b2e6e; color: #bdaf18">
                                        Complete peer evaluation
                                    </button>
                                </a>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>