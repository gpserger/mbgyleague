<?php require 'mbgyleague/Connections/Connections.php' ?>
<?php
    session_start();
    if(isset($_SESSION["UserID"])){
      $id = $_SESSION["UserID"];
      $result = mysqli_query($con, "SELECT Userlevel FROM `user` WHERE UserID = $id");
      $Userlevel = $result['Userlevel'];
      if($Userlevel >= 10){

      } else {
        header('Location: error.php?code=1');
      }

    } else {
      header('Location: Login.php');

    }
?>
<!DOCTYPE html>
<html>
<head>
    <link href="mbgyleague/mbgyleague-css/Menu.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Master.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>CHANGE ME</title>
</head>

<body>
    <div class="Container">
        <div class="Header">
        </div>
        <div class="menu">
            <div id="Menu">
                <nav>
                    <ul class="cssmenu">

                        <li><a href="#">Register</a></li>
                        <li><a href="#">Log in</a></li>

                    </ul>
                </nav>
            </div>

        </div>
        <div class="LeftBody"></div>
        <div class="RightBody">
          <p>MySQL Query:</p>
          <textarea rows="4" cols="50" form="sqlquery" name="query">At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies.
          </textarea>
          <br/>
          <form action="output.php" id="sqlquery" method="post">
            <div class="FormElement">
                <input name="Register" type="submit" value="Register" title="Register" id="Register" class="button">
            </div>
          </form>
        </div>
        <div class="Footer"></div>
    </div>

</body>
</html>
