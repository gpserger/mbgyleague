<?php require 'mbgyleague/Connections/Connections.php' ?>
<?php
    session_start();
    if(isset($_SESSION["UserID"])){
      $id = $_SESSION["UserID"];
      $result = mysqli_query($con, "SELECT Userlevel FROM `user` WHERE UserID = $id");
      $resultarray = mysqli_fetch_array($result);
      $Userlevel = $resultarray['Userlevel'];
      if($Userlevel >= 10){

      } else {
        header('Location: error.php?code=1');
      }

    } else {
      header('Location: Login.php');

    }

    if(isset($_POST['Query'])) {
      $querystring = $_POST['queryfield'];
      $sql = $con->query($querystring);
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
          <textarea rows="4" cols="50" form="sqlquery" name="query" id="queryfield">Enter mysql query.          </textarea>
          <br/>
          <form action="output.php" id="sqlquery" method="post">
            <div class="FormElement">
                <input name="Query" type="submit" value="Query" title="Query" id="Query" class="button">
            </div>
          </form>
          <br>
          <br>
          <h2>Add match:</h2>
          <form>
            Player 1: <input name="Player 1" type="text" class="TField" id"player1" placeholder="UserID">
            Player 2: <input name="Player 2" type="text" class="TField" id"player2" placeholder="UserID">
            Winner: 1<input type="radio" name="winner" value="Player 1">
            2<input type="radio" name="winner" value="Player 2">
          </form>
        </div>
        <div class="Footer"></div>
    </div>

</body>
</html>
