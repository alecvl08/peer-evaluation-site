<?php
    session_start();
    require_once("db.php");
    $sql = "SELECT AVG(Question_1), AVG(Question_2), (Question_1 + Question_2)/2 AS Section_1_Avg, 
        AVG(Question_3), AVG(Question_4), AVG(Question_5), AVG(Question_6), (Question_3 + Question_4 + Question_5 + Question_6)/4 AS Section_2_Avg, 
        AVG(Question_7), AVG(Question_8), AVG(Question_9), AVG(Question_10), (Question_7 + Question_8 + Question_9 + Question_10)/4 AS Section_3_Avg, 
        AVG(Question_11), AVG(Question_12), AVG(Question_13), AVG(Question_14), AVG(Question_15), (Question_11 + Question_12 + Question_13 + Question_14)/5 AS Section_4_Avg, 
        AVG(Question_16), AVG(Question_17), AVG(Question_18), AVG(Question_19), (Question_16 + Question_17 + Question_18 + Question_19)/4 AS Section_5_Avg, 
        (Question_1 + Question_2 + Question_3 + Question_4 + Question_5 + Question_6 + Question_7 + Question_8 +
        Question_9 + Question_10 + Question_11 + Question_12 + Question_13 + Question_14 + Question_15 +
        Question_16 + Question_17 + Question_18 + Question_19)/19 AS GrandAverage
        FROM Peer_Evaluation WHERE Evaluated_Student_ID = ".$_SESSION['Student_ID'].";";
    $result = $mydb->query($sql);
?>
<!DOCTYPE html>
<html lang="en" style="background-color: #ededed">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="bulma.css"/>
        <script src="https://kit.fontawesome.com/2b25a857ec.js" crossorigin="anonymous"></script>
        <title>Student Scores</title>
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
            <p>
                <strong>Evaluation results:</strong>
            </p>
            <table class="table is-bordered is-hoverable is-scrollable" style="background-color: #d8edf3">
                <tr>
                    <th>Question/Learning outcome</th>
                    <th>Average score</th>
                    <th>Status</th>
                </tr>
                <?php 
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td>1. Demonstrate life-ready disciplinary knowledge and expertise</td>
                    <td>
                        <?php echo $row['AVG(Question_1)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_1)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_1)'] < 4 && $row['AVG(Question_1)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_1)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_1)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_1)'] < 4 && $row['AVG(Question_1)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_1)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>2. Demonstrate ability to integrate and apply knowledge, within and across disciplines, in identifying and addressing real world problems</td>
                    <td>
                        <?php echo $row['AVG(Question_2)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_2)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_2)'] < 4 && $row['AVG(Question_2)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_2)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_2)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_2)'] < 4 && $row['AVG(Question_2)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_2)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Disciplinary and multidisciplinary knowledge average</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo $row['Section_1_Avg']; ?>
                        </strong>
                    </td>
                    <td
                        <?php 
                            if ($row['Section_1_Avg'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['Section_1_Avg'] < 4 && $row['Section_1_Avg'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['Section_1_Avg'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <strong>
                            <?php 
                                if ($row['Section_1_Avg'] >= 4) echo "Achieved";
                                if ($row['Section_1_Avg'] < 4 && $row['Section_1_Avg'] > 1) echo "Working towards";
                                if ($row['Section_1_Avg'] <= 1) echo "Needs improvement";
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>3. Demonstrate versatile and holistic use of reasoning, logic and evidence to evaluate information and make judgements</td>
                    <td>
                        <?php echo $row['AVG(Question_3)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_3)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_3)'] < 4 && $row['AVG(Question_3)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_3)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_3)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_3)'] < 4 && $row['AVG(Question_3)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_3)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>4. Demonstrate ability to solve problems with high levels of complexity and uncertainty</td>
                    <td>
                        <?php echo $row['AVG(Question_4)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_4)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_4)'] < 4 && $row['AVG(Question_4)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_4)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_4)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_4)'] < 4 && $row['AVG(Question_4)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_4)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>5. Demonstrate flexibility and out-of-the-box thinking when generating ideas</td>
                    <td>
                        <?php echo $row['AVG(Question_5)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_5)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_5)'] < 4 && $row['AVG(Question_5)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_5)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_5)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_5)'] < 4 && $row['AVG(Question_5)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_5)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>6. Demonstrate the ability and willingness to identify opportunities and to enact solutions as appropriate</td>
                    <td>
                        <?php echo $row['AVG(Question_6)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_6)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_6)'] < 4 && $row['AVG(Question_6)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_6)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_6)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_6)'] < 4 && $row['AVG(Question_6)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_6)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Intellectual and creative skills average</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo $row['Section_2_Avg']; ?>
                        </strong>
                    </td>
                    <td
                        <?php 
                            if ($row['Section_2_Avg'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['Section_2_Avg'] < 4 && $row['Section_2_Avg'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['Section_2_Avg'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <strong>
                            <?php 
                                if ($row['Section_2_Avg'] >= 4) echo "Achieved";
                                if ($row['Section_2_Avg'] < 4 && $row['Section_2_Avg'] > 1) echo "Working towards";
                                if ($row['Section_2_Avg'] <= 1) echo "Needs improvement";
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>7. Demonstrate empathy, emotional and situational intelligence in persuasion, negotiation and conflict resolution</td>
                    <td>
                        <?php echo $row['AVG(Question_7)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_7)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_7)'] < 4 && $row['AVG(Question_7)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_7)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_7)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_7)'] < 4 && $row['AVG(Question_7)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_7)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>8. Collaborate effectively in different settings in the pursuit of shared goals</td>
                    <td>
                        <?php echo $row['AVG(Question_8)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_8)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_8)'] < 4 && $row['AVG(Question_8)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_8)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_8)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_8)'] < 4 && $row['AVG(Question_8)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_8)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>9. Demonstrate ability to know when to follow and when to lead and to understand how to optimize the distribution of talent in any given situation</td>
                    <td>
                        <?php echo $row['AVG(Question_9)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_9)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_9)'] < 4 && $row['AVG(Question_9)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_9)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_9)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_9)'] < 4 && $row['AVG(Question_9)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_9)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>10. Communicate effectively in relevant genres and using appropriate modalities for different contexts</td>
                    <td>
                        <?php echo $row['AVG(Question_10)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_10)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_10)'] < 4 && $row['AVG(Question_10)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_10)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_10)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_10)'] < 4 && $row['AVG(Question_10)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_10)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Interpersonal skills average</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo $row['Section_3_Avg']; ?>
                        </strong>
                    </td>
                    <td
                        <?php 
                            if ($row['Section_3_Avg'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['Section_3_Avg'] < 4 && $row['Section_3_Avg'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['Section_3_Avg'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <strong>
                            <?php 
                                if ($row['Section_3_Avg'] >= 4) echo "Achieved";
                                if ($row['Section_3_Avg'] < 4 && $row['Section_3_Avg'] > 1) echo "Working towards";
                                if ($row['Section_3_Avg'] <= 1) echo "Needs improvement";
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>11. Demonstrate openness to different cultures</td>
                    <td>
                        <?php echo $row['AVG(Question_11)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_11)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_11)'] < 4 && $row['AVG(Question_11)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_11)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_11)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_11)'] < 4 && $row['AVG(Question_11)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_11)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>12. Appreciate and value the diversity of different social and cultural contexts</td>
                    <td>
                        <?php echo $row['AVG(Question_12)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_12)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_12)'] < 4 && $row['AVG(Question_12)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_12)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_12)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_12)'] < 4 && $row['AVG(Question_12)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_12)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>13. Be attuned to the specific issues and developments that pertain to Asia</td>
                    <td>
                        <?php echo $row['AVG(Question_13)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_13)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_13)'] < 4 && $row['AVG(Question_13)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_13)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_13)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_13)'] < 4 && $row['AVG(Question_13)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_13)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>14. Identify and be able to frame conflicting ethical values in personal, professional and societal settings</td>
                    <td>
                        <?php echo $row['AVG(Question_14)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_14)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_14)'] < 4 && $row['AVG(Question_15)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_14)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_14)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_14)'] < 4 && $row['AVG(Question_14)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_14)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>15. Demonstrate a sense of responsibility for the broader impact of individual and collective actions</td>
                    <td>
                        <?php echo $row['AVG(Question_15)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_15)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_15)'] < 4 && $row['AVG(Question_15)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_15)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_15)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_15)'] < 4 && $row['AVG(Question_15)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_15)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Global citizenship average</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo $row['Section_4_Avg']; ?>
                        </strong>
                    </td>
                    <td
                        <?php 
                            if ($row['Section_4_Avg'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['Section_4_Avg'] < 4 && $row['Section_4_Avg'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['Section_4_Avg'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <strong>
                            <?php 
                                if ($row['Section_4_Avg'] >= 4) echo "Achieved";
                                if ($row['Section_4_Avg'] < 4 && $row['Section_4_Avg'] > 1) echo "Working towards";
                                if ($row['Section_4_Avg'] <= 1) echo "Needs improvement";
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>16. Contribute positively to local and global communities by addressing social concerns</td>
                    <td>
                        <?php echo $row['AVG(Question_16)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_16)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_16)'] < 4 && $row['AVG(Question_16)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_16)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_16)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_16)'] < 4 && $row['AVG(Question_16)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_16)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>17. Demonstrate commitment to personal growth and development, and lifelong learning</td>
                    <td>
                        <?php echo $row['AVG(Question_17)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_17)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_17)'] < 4 && $row['AVG(Question_17)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_17)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_17)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_17)'] < 4 && $row['AVG(Question_17)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_17)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>18. Demonstrate an ability to be self-reflective about and improve on one’s learning processes</td>
                    <td>
                        <?php echo $row['AVG(Question_18)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_18)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_18)'] < 4 && $row['AVG(Question_18)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_18)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_18)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_18)'] < 4 && $row['AVG(Question_18)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_18)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>19. Demonstrate ability to persevere and to recover quickly in the face of disruptions and challenges</td>
                    <td>
                        <?php echo $row['AVG(Question_19)']; ?>
                    </td>
                    <td
                        <?php 
                            if ($row['AVG(Question_19)'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['AVG(Question_19)'] < 4 && $row['AVG(Question_19)'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['AVG(Question_19)'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <?php 
                            if ($row['AVG(Question_19)'] >= 4) echo "Achieved";
                            if ($row['AVG(Question_19)'] < 4 && $row['AVG(Question_19)'] > 1) echo "Working towards";
                            if ($row['AVG(Question_19)'] <= 1) echo "Needs improvement";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Personal mastery average</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo $row['Section_5_Avg']; ?>
                        </strong>
                    </td>
                    <td
                        <?php 
                            if ($row['Section_5_Avg'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['Section_5_Avg'] < 4 && $row['Section_5_Avg'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['Section_5_Avg'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <strong>
                            <?php 
                                if ($row['Section_5_Avg'] >= 4) echo "Achieved";
                                if ($row['Section_5_Avg'] < 4 && $row['Section_5_Avg'] > 1) echo "Working towards";
                                if ($row['Section_5_Avg'] <= 1) echo "Needs improvement";
                            ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>AVERAGE OF ALL</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo $row['GrandAverage']; ?>
                        </strong>
                    </td>
                    <td
                        <?php 
                            if ($row['GrandAverage'] >= 4) echo "style='background-color: lightgreen'";
                            if ($row['GrandAverage'] < 4 && $row['GrandAverage'] > 1) echo "style='background-color: lightyellow'";
                            if ($row['GrandAverage'] <= 1) echo "style='background-color: tomato'";
                        ?>>
                        <strong>
                            <?php 
                                if ($row['GrandAverage'] >= 4) echo "Achieved";
                                if ($row['GrandAverage'] < 4 && $row['GrandAverage'] > 1) echo "Working towards";
                                if ($row['GrandAverage'] <= 1) echo "Needs improvement";
                            ?>
                        </strong>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>
