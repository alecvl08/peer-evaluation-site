<?php
    require_once('db.php');
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $courseID = $_GET['courseID'];
        $sql = "DELETE FROM DBTeam4.Group WHERE Group_ID = '$id'";
        $result = $mydb ->query($sql);
        $sql = "DELETE FROM Group_Membership WHERE Group_ID = '$id'";
        $result = $mydb ->query($sql);
        echo "<meta http-equiv='refresh' content='0;url=professorspecificcourse.php?courseID=$courseID'>"; //refresh page (alternatively can use ajax for seamless experience)
    }
?>