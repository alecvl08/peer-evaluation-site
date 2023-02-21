<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" style="background-color: #ededed">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="bulma.css"/>
        <script src="https://kit.fontawesome.com/2b25a857ec.js" crossorigin="anonymous"></script>
        <title>Student Menu</title>
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
        <h2 class="title is-2" style="text-align: center; font: arial; color: #0b2e6e">Student Menu</h2>
        <div class="section is-medium">
            <div class="columns is-centered is-vcentered">
                <div class="column is-narrow">
                    <button class="button is-large" style="background-color: #0b2e6e; color: #bdaf18" id="courses" onclick='window.location.href = "studentcourses.php"'>
                        <span class="icon">
                            <i class="fas fa-pencil-alt"></i>
                        </span>
                        <p>My courses</p>
                    </button>
                </div>
                <div class="column is-narrow">
                    <button class="button is-large" style="background-color: #0b2e6e; color: #bdaf18" id="scores" onclick='window.location.href = "studentscores.php"'>
                        <span class="icon">
                            <i class="fas fa-trophy"></i>
                        </span>
                        <p>My scores</P>
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
