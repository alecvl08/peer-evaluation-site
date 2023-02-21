<?php
    $Student_ID;
    $Professor_ID;
    $username="";
    $password="";
    $userType;
    $error = false;
    $loginOK = false;
    $result = null;
    if(isset($_POST["login"])) {
        
        if(isset($_POST["username"])) $username=$_POST["username"];
        if(isset($_POST["password"])) $password=$_POST["password"];
        if(isset($_POST["userType"])) $userType=$_POST["userType"];

        if(empty($username) || empty($password) || empty($userType)) {
            $error=true;
        }

        if(!$error) {
            if($userType == "student") {
                require_once("db.php");
                $sql = "select Student_ID, Username, Password from Student where Username='$username'";
                $result = $mydb->query($sql);

                $row=mysqli_fetch_array($result);
                if ($row){
                    if(strcmp($password, $row["Password"]) ==0){
                        $loginOK = true;
                    }
                }
                if ($loginOK==true) {
                    $Student_ID = $row['Student_ID'];
                    session_start();
                    $_SESSION['Student_ID'] = $Student_ID;
                    $_SESSION["Username"] = $username;
                    $_SESSION["Password"] = $password;
                    Header("Location:studentmenu.php");
                }
                if ($loginOK==false) {
                    echo "<script>alert('Invalid credentials')</script>";
                }
            }
            if($userType == "professor") {
                require_once("db.php");
                $sql = "select Professor_ID, Username, Prof_Password from Professor where Username='$username'";
                $result = $mydb->query($sql);

                $row=mysqli_fetch_array($result);
                if ($row){
                    if(strcmp($password, $row["Prof_Password"]) ==0){
                        $loginOK = true;
                    }
                }
                if($loginOK==true) {
                    $Professor_ID = $row['Professor_ID'];
                    session_start();
                    $_SESSION['Professor_ID'] = $Professor_ID;
                    $_SESSION["Username"] = $username;
                    $_SESSION["Prof_Password"] = $password;
                    Header("Location:professormenu.php");
                }
                if ($loginOK==false) {
                    echo "<script>alert('Invalid credentials')</script>";
                }
            }
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
        <title>Login</title>
    </head>
    <body>
        <div class="columns">
            <div class="column" style="background-color: #0b2e6e; text-align: center; vertical-align: center">
                <h1 class="title is-1" style="font: arial; color: #bdaf18">SMU Evaluations</h1>
                <img src="smulogo.gif" style="height: 300px">
            </div>
            <div class="column" style="text-align: center">
                <h1 class="title is-1" style="font: arial; color: #0b2e6e">Login</h1>
                <form method="post">
                    <div class="field">
                        <div class="control">
                            <input class="radio" type="radio" id="professor" name="userType" value="professor">
                            <label class="radio" for="professor">Professor</label>
                            <input class="radio" type="radio" id="student" name="userType" value="student">
                            <label class="radio" for="student">Student</label>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="username">Username: </label>
                        <input class="input" type="text" name="username" id="username">
                    </div>
                    <div class="field">
                        <label class="label" for="password">Password: </label>
                        <input class="input" type="password" name="password" id="password":>
                    </div>
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit" name="login">
                            <input type="reset" name="reset">
                        </div>
                    </div>          
                </form>
            </div>
        </div>
    </body>
</html>