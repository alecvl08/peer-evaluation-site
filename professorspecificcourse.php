<?php
    session_start();
    require_once("db.php");

    $sql = "SELECT Course_ID, Course_Name, Course_Term, Course_Year, Course_Eval_StartDate, Course_Eval_EndDate FROM Course WHERE Course_ID = ".$_GET['courseID'];
    $courseResult = $mydb->query($sql);

    $sql = "SELECT Group_Name, Group_Number, Group_ID FROM DBTeam4.Group WHERE Course_ID = ".$_GET['courseID']." ORDER BY Group_Number;";
    $groupsResult = $mydb->query($sql);

    $sql = "SELECT Student.Student_ID, First_Name, Last_Name FROM Student INNER JOIN Enrollment ON Student.Student_ID = Enrollment.Student_ID WHERE Course_ID = ".$_GET['courseID'];
    $studentsResult = $mydb->query($sql);
    $studentCount = mysqli_num_rows($studentsResult);
    
    $error = false;

    //New group processing
    if (isset($_POST["submitGroup"])) {
        if (isset($_POST["groupName"])) $groupName = $_POST["groupName"];
        if (isset($_POST["groupNum"])) $groupNum = $_POST["groupNum"];

        if (empty($groupName) || empty($groupNum)) {
            $error = true;
        }
        
        if (!$error) {
            require_once("db.php");
            $sql = "SELECT Course_ID, Group_Number FROM DBTeam4.Group WHERE Course_ID = ".$_GET['courseID']." AND Group_Number = ".$groupNum.";";
            $groupNumberResult = $mydb->query($sql);
            while ($groupNumberRow = mysqli_fetch_array($groupNumberResult)) {
                if ($groupNum == $groupNumberRow['Group_Number']) $error = true;
            }
            if (!$error) {
                $sql = $mydb->dbConn->prepare("INSERT INTO DBTeam4.Group(Group_Name, Group_Number, Course_ID)
                values (?, ?, ?)");
                $sql->bind_param('sii', $groupName, $groupNum, $_GET['courseID']);
                $result = $sql->execute();
                if($result) {
                    echo "<script>
                        window.location.href = 'professorspecificcourse.php?courseID=".$_GET['courseID']."'
                    </script>";
                    
                }
                else {
                    echo "<script>alert('Database error')</script>";
                }
            }
            else {
                echo "<script>alert('Group number already exists for this course')</script>";
            }
        }
        else {
            echo "<script>alert('Empty field(s)')</script>";
        }
    }

    //Evaluation dates processing
    if (isset($_POST["submitEvalDates"])) {
        if (isset($_POST["evalStart"])) {
            $evalStart = date_format(date_create($_POST["evalStart"]), "Y/m/d"); //formats date correctly
        }
        if (isset($_POST["evalEnd"])) {
            $evalEnd = date_format(date_create($_POST["evalEnd"]), "Y/m/d"); //formats date correctly
        }

        if (empty($evalStart) || empty($evalEnd)) {
            $error = true;
            echo "<script>alert('Empty field(s)')</script>";
        }

        if ($evalStart > $evalEnd) {
            $error = true;
            echo "<script>alert('Evaluation start date cannot be after the end date')</script>";
        }
        
        if (!$error) {
            require_once("db.php");
            $sql = $mydb->dbConn->prepare("UPDATE Course SET Course_Eval_StartDate = ?, Course_Eval_EndDate = ?
                WHERE Course_ID = ".$_GET['courseID'].";");
            $sql->bind_param('ss', $evalStart, $evalEnd);
            $result = $sql->execute();
            if($result) {
                echo "<script>
                    window.location.href = 'professorspecificcourse.php?courseID=".$_GET['courseID']."'
                </script>";
                
            }
            else {
                echo "<script>alert('Database error')</script>";
            }
        }
    }

    //Group assignment processing
    if (isset($_POST["groupAssignmentSubmit"])) {

        if (isset($_POST["groupSelect"])) $groupID = $_POST["groupSelect"];
        if (isset($_POST["studentID"])) $studentID = $_POST["studentID"];
        
        require_once("db.php");
        $sql = "DELETE Group_Membership FROM Group_Membership
                INNER JOIN DBTeam4.Group ON Group_Membership.Group_ID = DBTeam4.Group.Group_ID
                WHERE Student_ID = '$studentID' AND Course_ID = ".$_GET['courseID'].";"; //removes any existing group assignments for this student in this course
        $result = $mydb ->query($sql);
        $sql = $mydb->dbConn->prepare("REPLACE INTO Group_Membership(Group_ID, Student_ID)
        values (?, ?)");
        $sql->bind_param('ii', $groupID, $studentID);
        $result = $sql->execute();
        if($result) {
            echo "<script>
                window.location.href = 'professorspecificcourse.php?courseID=".$_GET['courseID']."'
            </script>";
            
        }
        else {
            echo "<script>alert('Database error')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en" style="background-color: #ededed">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="bulma.css"/>
        <title>Course</title>
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
        <?php while($row=mysqli_fetch_array($courseResult))
            {
        ?>
            <h2 class="title is-2" style="text-align: center; font: arial; color: #0b2e6e">
                Course <?php echo $row['Course_ID']; ?>: <?php echo $row['Course_Name']; ?> - Term <?php echo $row['Course_Term']; ?> - <?php echo $row['Course_Year']; ?>
            </h2>
        <?php
            }
        ?>

        <!--EVALUATION DATES FORM-->
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <p>
                <strong>Schedule peer evaluations:</strong>
            </p>
            <form method="post">
                <label for="groupName">Evaluations start date:</label>
                <input type="date" id="evalStart" name="evalStart">
                <label for="groupNum">Evaluations due date:</label>
                <input type="date" id="evalEnd" name="evalEnd">
                <input type="submit" id="submitEvalDates" name="submitEvalDates">
            </form>
        </div>

        <!--SAVED EVALUATION DATES-->
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <p>
                <strong>Evaluation dates:</strong>
            </p>
            <table class="table is-hoverable is-scrollable" style="background-color: #d8edf3">
                <tr>
                    <th>Start date</th>
                    <th>Due date</th>
                </tr>
                <?php
                    $sql = "SELECT Course_Eval_StartDate, Course_Eval_EndDate FROM Course WHERE Course_ID = ".$_GET['courseID'];
                    $courseEvalDatesResult = $mydb->query($sql);
                    while($row=mysqli_fetch_array($courseEvalDatesResult)) {
                ?>
                <tr>
                    <td>
                        <?php echo $row['Course_Eval_StartDate']; ?>
                    </td>
                    <td>
                        <?php echo $row['Course_Eval_EndDate']; ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        
        <!--GROUP CREATION FORM-->
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <p>
                <strong>Create groups:</strong>
            </p>
            <form method="post">
                <label for="groupName">Group name:</label>
                <input type="text" id="groupName" name="groupName">
                <label for="groupNum">Group number:</label>
                <input type="number" id="groupNum" name="groupNum">
                <input type="submit" id="submitGroup" name="submitGroup">
            </form>
        </div>

        <!--EXISTING GROUPS TABLE-->
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <p>
                <strong>Existing groups:</strong>
            </p>
            <table class="table is-hoverable is-scrollable" style="background-color: #d8edf3">
                <tr>
                    <th>Group name</th>
                    <th>Group number</th>
                    <th>Delete</th>
                </tr>
                <?php
                    while($row=mysqli_fetch_array($groupsResult)) {
                ?>
                <tr>
                    <td>
                        <?php echo $row['Group_Name']; ?>
                    </td>
                    <td>
                        <?php echo $row['Group_Number']; ?>
                    </td>
                    <td>
                        <a href="deletegroup.php?del=<?php echo $row['Group_ID']; ?>&courseID=<?php echo $_GET['courseID']; ?>">Delete</a>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>

        <!--ENROLLED STUDENTS TABLE AND GROUP ASSIGNMENT FORM-->
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <p>
                <strong>Enrolled students:</strong>
            </p>
            <table class="table is-hoverable is-scrollable" style="background-color: #d8edf3">
                <tr>
                    <th>Student ID</th>
                    <th>First</th>
                    <th>Last</th>
                    <th>Group</th>
                    <th style="display: none"></th>
                </tr>
                <?php
                    while($row=mysqli_fetch_array($studentsResult)) {
                ?>
                <form method="post" name="groupAssignmentForm">
                    <tr>
                        <td>
                            <input type="number" name="studentID" id="studentID" value = <?php echo $row['Student_ID']; ?> readonly>
                        </td>
                        <td>
                            <?php echo $row['First_Name']; ?>
                        </td>
                        <td>
                            <?php echo $row['Last_Name']; ?>
                        </td>
                        <td>
                            <select id="groupSelect" name="groupSelect">
                                <option value=""></option>
                                <?php
                                    $sql = "SELECT Group_ID, Group_Number, Group_Name FROM DBTeam4.Group WHERE Course_ID = ".$_GET['courseID']." ORDER BY Group_Number;";
                                    $groupResult = $mydb->query($sql);
                                    while($groupRow=mysqli_fetch_array($groupResult)) {
                                ?>
                                <option value="<?php echo $groupRow['Group_ID']; ?>"
                                    <?php
                                        $sql = "SELECT DBTeam4.Group.Group_ID, Group_Name FROM Group_Membership 
                                            INNER JOIN DBTeam4.Group ON Group_Membership.Group_ID = DBTeam4.Group.Group_ID 
                                            WHERE Student_ID = ".$row['Student_ID']." AND Course_ID = ".$_GET['courseID'].";";
                                        $currentGroupResult = $mydb->query($sql);
                                        while($currentGroupRow=mysqli_fetch_array($currentGroupResult)) {
                                            $currentGroup = $currentGroupRow['Group_ID'];
                                            if ($currentGroup == $groupRow['Group_ID']) echo " selected";
                                        }
                                     ?>>
                                    <?php echo $groupRow['Group_Name']; ?>
                                </option>
                                <?php
                                    }
                                ?>
                            </select>
                        </td>
                        <td class="submit" id="submit" name="submit">
                            <input type="submit" name="groupAssignmentSubmit" id="groupAssignmentSubmit" class="groupAssignmentSubmit">
                        </td>
                    </tr>
                </form>
                <?php
                    }
                ?>
            </table>
        </div>
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <p>
                <strong>Intelligence dashboard:</strong>
            </p>
            <iframe height="800" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiODIzMWNmZmYtYjcwYS00YmVkLWI5ZjQtMGM0MDViMWIyZDY0IiwidCI6IjYwOTU2ODg0LTEwYWQtNDBmYS04NjNkLTRmMzJjMWUzYTM3YSIsImMiOjF9&pageName=ReportSectionf590d52aa74d8695cded" frameborder="0" allowFullScreen="true"></iframe>
            <iframe height="800" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiYWQxZjQ5NWItODZlYS00NjY4LTk4NjktYmNiMWZjNDkwN2I1IiwidCI6IjYwOTU2ODg0LTEwYWQtNDBmYS04NjNkLTRmMzJjMWUzYTM3YSIsImMiOjF9" frameborder="0" allowFullScreen="true"></iframe>
        </div>
    </body>
</html>