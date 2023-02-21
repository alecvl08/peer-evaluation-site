<?php
    session_start();
    require_once("db.php");
    $sql = "SELECT Student.Student_ID, First_Name, Last_Name FROM Student
    INNER JOIN Group_Membership ON Student.Student_ID = Group_Membership.Student_ID
    WHERE Group_Membership.Group_ID = ".$_GET['groupID']." AND Student.Student_ID = ".$_GET['studentID'].";";
    $result = $mydb->query($sql);
    $error = false;
    if (isset($_POST["submit"])) {
        $studentID = $_SESSION['Student_ID'];
        $groupID = $_GET['groupID'];
        if (isset($_POST["evaluatedStudent"])) $evaluatedStudentID = $_POST["evaluatedStudent"];
        if (isset($_POST["question1"])) $question1 = $_POST["question1"];
        if (isset($_POST["question2"])) $question2 = $_POST["question2"];
        if (isset($_POST["question3"])) $question3 = $_POST["question3"];
        if (isset($_POST["question4"])) $question4 = $_POST["question4"];
        if (isset($_POST["question5"])) $question5 = $_POST["question5"];
        if (isset($_POST["question6"])) $question6 = $_POST["question6"];
        if (isset($_POST["question7"])) $question7 = $_POST["question7"];
        if (isset($_POST["question8"])) $question8 = $_POST["question8"];
        if (isset($_POST["question9"])) $question9 = $_POST["question9"];
        if (isset($_POST["question10"])) $question10 = $_POST["question10"];
        if (isset($_POST["question11"])) $question11 = $_POST["question11"];
        if (isset($_POST["question12"])) $question12 = $_POST["question12"];
        if (isset($_POST["question13"])) $question13 = $_POST["question13"];
        if (isset($_POST["question14"])) $question14 = $_POST["question14"];
        if (isset($_POST["question15"])) $question15 = $_POST["question15"];
        if (isset($_POST["question16"])) $question16 = $_POST["question16"];
        if (isset($_POST["question17"])) $question17 = $_POST["question17"];
        if (isset($_POST["question18"])) $question18 = $_POST["question18"];
        if (isset($_POST["question19"])) $question19 = $_POST["question19"];
        if (empty($studentID) || empty($evaluatedStudentID) || empty($question1) || empty($question2) || empty($question3) || empty($question4) || empty($question5) || empty($question6) || empty($question7) || empty($question8) || empty($question9) || empty($question10) || empty($question11) || empty($question12) || empty($question13) || empty($question14) || empty($question15) || empty($question16) || empty($question17) || empty($question18) || empty($question19)) {
            $error = true;
        }
        
        if (!$error) {
            require_once("db.php");
            $sql = $mydb->dbConn->prepare("insert into DBTeam4.Peer_Evaluation(Student_ID, Evaluated_Student_ID, Group_ID, Question_1, Question_2, Question_3, Question_4, Question_5, Question_6, Question_7, Question_8, Question_9, Question_10, Question_11, Question_12, Question_13, Question_14, Question_15, Question_16, Question_17, Question_18, Question_19)
            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->bind_param('iiiiiiiiiiiiiiiiiiiiii', $studentID, $evaluatedStudentID, $groupID, $question1, $question2, $question3, $question4, $question5, $question6, $question7, $question8, $question9, $question10, $question11, $question12, $question13, $question14, $question15, $question16, $question17, $question18, $question19);
            $result = $sql->execute();
            if($result) {
                echo "<script>alert('Record has been successfully added')
                    window.location.href = 'studentgroup.php?groupID=".$_GET['groupID']."&courseID=".$_GET['courseID']."'
                </script>";
                
            }
            else {
                echo "<script>alert('Database error 1')</script>";
            }
        }
        else {
            echo "<script>alert('Database error:')</script>";
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
        <title>Peer Evaluation</title>
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
        <div class="m-6 p-1" style="background-color: #d8edf3; border: 3px solid #bdaf18">
            <form method="post">
                <label for="evaluatedStudent">Student being evaluated:</label>
                <select name="evaluatedStudent" id="evaluatedStudent">
                    <?php
                        while($row=mysqli_fetch_array($result)) {
                    ?>
                    <option value="<?php echo $row['Student_ID']; ?>">
                        <?php echo $row['First_Name']." ".$row['Last_Name']; ?>
                    </option>
                    <?php
                        }
                    ?>
                </select>

                <p>
                    <strong>Instructions: </strong>Complete the form, rating your peer from 1 (worst) to 5 (best) on their ability to do the following:
                </p>
                <p>
                    <strong>Disciplinary and multidisciplinary knowledge</strong>
                </p>
                1. Demonstrate life-ready disciplinary knowledge and expertise
                </br>
                <input type="radio" id="1.1" name="question1" value="1">
                <label for="1.1">1</label>
                <input type="radio" id="1.2" name="question1" value="2">
                <label for="1.2">2</label>
                <input type="radio" id="1.3" name="question1" value="3">
                <label for="1.3">3</label>
                <input type="radio" id="1.4" name="question1" value="4">
                <label for="1.4">4</label>
                <input type="radio" id="1.5" name="question1" value="5">
                <label for="1.5">5</label>
                </br>
                2. Demonstrate ability to integrate and apply knowledge, within and across disciplines, in identifying and addressing real world problems
                </br>
                <input type="radio" id="2.1" name="question2" value="1">
                <label for="2.1">1</label>
                <input type="radio" id="2.2" name="question2" value="2">
                <label for="2.2">2</label>
                <input type="radio" id="2.3" name="question2" value="3">
                <label for="2.3">3</label>
                <input type="radio" id="2.4" name="question2" value="4">
                <label for="2.4">4</label>
                <input type="radio" id="2.5" name="question2" value="5">
                <label for="2.5">5</label>
                </br>
                <p>
                    <strong>Intellectual and creative skills</strong>
                </p>
                3. Demonstrate versatile and holistic use of reasoning, logic and evidence to evaluate information and make judgements
                </br>
                <input type="radio" id="3.1" name="question3" value="1">
                <label for="3.1">1</label>
                <input type="radio" id="3.2" name="question3" value="2">
                <label for="3.2">2</label>
                <input type="radio" id="3.3" name="question3" value="3">
                <label for="3.3">3</label>
                <input type="radio" id="3.4" name="question3" value="4">
                <label for="3.4">4</label>
                <input type="radio" id="3.5" name="question3" value="5">
                <label for="3.5">5</label>
                </br>
                4. Demonstrate ability to solve problems with high levels of complexity and uncertainty
                </br>
                <input type="radio" id="4.1" name="question4" value="1">
                <label for="4.1">1</label>
                <input type="radio" id="4.2" name="question4" value="2">
                <label for="4.2">2</label>
                <input type="radio" id="4.3" name="question4" value="3">
                <label for="4.3">3</label>
                <input type="radio" id="4.4" name="question4" value="4">
                <label for="4.4">4</label>
                <input type="radio" id="4.5" name="question4" value="5">
                <label for="4.5">5</label>
                </br>
                5. Demonstrate flexibility and out-of-the-box thinking when generating ideas
                </br>
                <input type="radio" id="5.1" name="question5" value="1">
                <label for="5.1">1</label>
                <input type="radio" id="5.2" name="question5" value="2">
                <label for="5.2">2</label>
                <input type="radio" id="5.3" name="question5" value="3">
                <label for="5.3">3</label>
                <input type="radio" id="5.4" name="question5" value="4">
                <label for="5.4">4</label>
                <input type="radio" id="5.5" name="question5" value="5">
                <label for="5.5">5</label>
                </br>
                6. Demonstrate the ability and willingness to identify opportunities and to enact solutions as appropriate
                </br>
                <input type="radio" id="6.1" name="question6" value="1">
                <label for="6.1">1</label>
                <input type="radio" id="6.2" name="question6" value="2">
                <label for="6.2">2</label>
                <input type="radio" id="6.3" name="question6" value="3">
                <label for="6.3">3</label>
                <input type="radio" id="6.4" name="question6" value="4">
                <label for="6.4">4</label>
                <input type="radio" id="6.5" name="question6" value="5">
                <label for="6.5">5</label>
                </br>
                <p>
                    <strong>Interpersonal skills</strong>
                </p>
                7. Demonstrate empathy, emotional and situational intelligence in persuasion, negotiation and conflict resolution
                </br>
                <input type="radio" id="7.1" name="question7" value="1">
                <label for="7.1">1</label>
                <input type="radio" id="7.2" name="question7" value="2">
                <label for="7.2">2</label>
                <input type="radio" id="7.3" name="question7" value="3">
                <label for="7.3">3</label>
                <input type="radio" id="7.4" name="question7" value="4">
                <label for="7.4">4</label>
                <input type="radio" id="7.5" name="question7" value="5">
                <label for="7.5">5</label>
                </br>
                8. Collaborate effectively in different settings in the pursuit of shared goals
                </br>
                <input type="radio" id="8.1" name="question8" value="1">
                <label for="8.1">1</label>
                <input type="radio" id="8.2" name="question8" value="2">
                <label for="8.2">2</label>
                <input type="radio" id="8.3" name="question8" value="3">
                <label for="8.3">3</label>
                <input type="radio" id="8.4" name="question8" value="4">
                <label for="8.4">4</label>
                <input type="radio" id="8.5" name="question8" value="5">
                <label for="8.5">5</label>
                </br>
                9. Demonstrate ability to know when to follow and when to lead and to understand how to optimize the distribution of talent in any given situation
                </br>
                <input type="radio" id="9.1" name="question9" value="1">
                <label for="9.1">1</label>
                <input type="radio" id="9.2" name="question9" value="2">
                <label for="9.2">2</label>
                <input type="radio" id="9.3" name="question9" value="3">
                <label for="9.3">3</label>
                <input type="radio" id="9.4" name="question9" value="4">
                <label for="9.4">4</label>
                <input type="radio" id="9.5" name="question9" value="5">
                <label for="9.5">5</label>
                </br>
                10. Communicate effectively in relevant genres and using appropriate modalities for different contexts
                </br>
                <input type="radio" id="10.1" name="question10" value="1">
                <label for="10.1">1</label>
                <input type="radio" id="10.2" name="question10" value="2">
                <label for="10.2">2</label>
                <input type="radio" id="10.3" name="question10" value="3">
                <label for="10.3">3</label>
                <input type="radio" id="10.4" name="question10" value="4">
                <label for="10.4">4</label>
                <input type="radio" id="10.5" name="question10" value="5">
                <label for="10.5">5</label>
                </br>
                <p>
                    <strong>Global citizenship</strong>
                </p>
                11. Demonstrate openness to different cultures
                </br>
                <input type="radio" id="11.1" name="question11" value="1">
                <label for="11.1">1</label>
                <input type="radio" id="11.2" name="question11" value="2">
                <label for="11.2">2</label>
                <input type="radio" id="11.3" name="question11" value="3">
                <label for="11.3">3</label>
                <input type="radio" id="11.4" name="question11" value="4">
                <label for="11.4">4</label>
                <input type="radio" id="11.5" name="question11" value="5">
                <label for="11.5">5</label>
                </br>
                12. Appreciate and value the diversity of different social and cultural contexts
                </br>
                <input type="radio" id="12.1" name="question12" value="1">
                <label for="12.1">1</label>
                <input type="radio" id="12.2" name="question12" value="2">
                <label for="12.2">2</label>
                <input type="radio" id="12.3" name="question12" value="3">
                <label for="12.3">3</label>
                <input type="radio" id="12.4" name="question12" value="4">
                <label for="12.4">4</label>
                <input type="radio" id="12.5" name="question12" value="5">
                <label for="12.5">5</label>
                </br>
                13. Be attuned to the specific issues and developments that pertain to Asia
                </br>
                <input type="radio" id="13.1" name="question13" value="1">
                <label for="13.1">1</label>
                <input type="radio" id="13.2" name="question13" value="2">
                <label for="13.2">2</label>
                <input type="radio" id="13.3" name="question13" value="3">
                <label for="13.3">3</label>
                <input type="radio" id="13.4" name="question13" value="4">
                <label for="13.4">4</label>
                <input type="radio" id="13.5" name="question13" value="5">
                <label for="13.5">5</label>
                </br>
                14. Identify and be able to frame conflicting ethical values in personal, professional and societal settings
                </br>
                <input type="radio" id="14.1" name="question14" value="1">
                <label for="14.1">1</label>
                <input type="radio" id="14.2" name="question14" value="2">
                <label for="14.2">2</label>
                <input type="radio" id="14.3" name="question14" value="3">
                <label for="14.3">3</label>
                <input type="radio" id="14.4" name="question14" value="4">
                <label for="14.4">4</label>
                <input type="radio" id="14.5" name="question14" value="5">
                <label for="14.5">5</label>
                </br>
                15. Demonstrate a sense of responsibility for the broader impact of individual and collective actions
                </br>
                <input type="radio" id="15.1" name="question15" value="1">
                <label for="15.1">1</label>
                <input type="radio" id="15.2" name="question15" value="2">
                <label for="15.2">2</label>
                <input type="radio" id="15.3" name="question15" value="3">
                <label for="15.3">3</label>
                <input type="radio" id="15.4" name="question15" value="4">
                <label for="15.4">4</label>
                <input type="radio" id="15.5" name="question15" value="5">
                <label for="15.5">5</label>
                </br>
                <p>
                    <strong>Personal mastery</strong>
                </p>
                16. Contribute positively to local and global communities by addressing social concerns
                </br>
                <input type="radio" id="16.1" name="question16" value="1">
                <label for="16.1">1</label>
                <input type="radio" id="16.2" name="question16" value="2">
                <label for="16.2">2</label>
                <input type="radio" id="16.3" name="question16" value="3">
                <label for="16.3">3</label>
                <input type="radio" id="16.4" name="question16" value="4">
                <label for="16.4">4</label>
                <input type="radio" id="16.5" name="question16" value="5">
                <label for="16.5">5</label>
                </br>
                17. Demonstrate commitment to personal growth and development, and lifelong learning
                </br>
                <input type="radio" id="17.1" name="question17" value="1">
                <label for="17.1">1</label>
                <input type="radio" id="17.2" name="question17" value="2">
                <label for="17.2">2</label>
                <input type="radio" id="17.3" name="question17" value="3">
                <label for="17.3">3</label>
                <input type="radio" id="17.4" name="question17" value="4">
                <label for="17.4">4</label>
                <input type="radio" id="17.5" name="question17" value="5">
                <label for="17.5">5</label>
                </br>
                18. Demonstrate an ability to be self-reflective about and improve on one’s learning processes
                </br>
                <input type="radio" id="18.1" name="question18" value="1">
                <label for="18.1">1</label>
                <input type="radio" id="18.2" name="question18" value="2">
                <label for="18.2">2</label>
                <input type="radio" id="18.3" name="question18" value="3">
                <label for="18.3">3</label>
                <input type="radio" id="18.4" name="question18" value="4">
                <label for="18.4">4</label>
                <input type="radio" id="18.5" name="question18" value="5">
                <label for="18.5">5</label>
                </br>
                19. Demonstrate ability to persevere and to recover quickly in the face of disruptions and challenges
                </br>
                <input type="radio" id="19.1" name="question19" value="1">
                <label for="19.1">1</label>
                <input type="radio" id="19.2" name="question19" value="2">
                <label for="19.2">2</label>
                <input type="radio" id="19.3" name="question19" value="3">
                <label for="19.3">3</label>
                <input type="radio" id="19.4" name="question19" value="4">
                <label for="19.4">4</label>
                <input type="radio" id="19.5" name="question19" value="5">
                <label for="19.5">5</label>
                </br></br>
                <input type="submit" name="submit" value="Submit">
                <input type="reset">
            </form>
        </div>
    </body>
</html>