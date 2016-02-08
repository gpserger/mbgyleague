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
          <h2>Calculate match:</h2>
          <!--http://www.w3schools.com/php/php_form_complete.asp-->
          <form action="" method="post" name="CalculateForm" id="CalculateForm">
            <div class="FormElement">
              <input name="player1id" type="text" class="TField" id="player1" placeholder="Player 1 UserID" value="<?php if(isset($_POST['player1id']))echo $_POST['player1id'];?>">
            </div>
            <div class="FormElement">
              <input name="player2id" type="text" class="TField" id="player2" placeholder="Player 2 UserID" value="<?php if(isset($_POST['player2id']))echo $_POST['player2id'];?>">
            </div>
            <div class="FormElement">
              Winner: <br>
              <input type="radio" name="winner" <?php if(isset($_POST['winner']) && $_POST['winner']=="player1") echo "checked";?> value="player1"> Player 1
              <input type="radio" name="winner" <?php if(isset($_POST['winner']) && $_POST['winner']=="player2") echo "checked";?> value="player2"> Player 2
            </div>
            <div class="FormElement">
              <input name="Calculate" type="submit" value="Calculate" title="Calculate" id="Calculate" class="button">
            </div>
            <br/>
            <?php

            $debug = 0;
            //Run when calc button is pressed.
  					if(isset($_POST['Calculate'])) {
              if(isset($_POST['player1id'])){
                $player1id = $_POST['player1id'];
              } else {
                $player1id = 1;
              }
              if(isset($_POST['player2id'])){
                $player2id = $_POST['player2id'];
              } else {
                $player2id = 1;
              }
              $winner = $_POST['winner'];
              if ($winner=="player1") {
                $win1=1;
                $win2=0;
                $winner=1;
              } else {
                $win1=0;
                $win2=1;
                $winner=2;
              }

              $player1result = mysqli_query($con,"SELECT elo FROM `lolplayers` WHERE id = $player1id;");
              $player2result = mysqli_query($con,"SELECT elo FROM `lolplayers` WHERE id = $player2id;");
              $row1 = mysqli_fetch_array($player1result);
              $row2 = mysqli_fetch_array($player2result);
              $R1 = $row1['elo'];
              $R2 = $row2['elo'];

              if(!isset($R1)||!isset($R2)) {
                echo "User(s) do(es) not have a rating";
              } else {

                $E1 = 1/(1+pow(10,(($R2-$R1)/400)));
                $E2 = 1-$E1;
                $R1new = $R1+160*($win1-$E1);
                $R2new = $R2+160*($win2-$E2);

                if ($debug==1) {
                  echo "Player 1 id, elo: " . "<strong>" . $player1id . ", " . $R1 . "</strong><br/>";
                  echo "Player 2 id, elo: " . "<strong>" . $player2id . ", " . $R2 . "</strong><br/>";
                  echo "Winner: " . "<strong>Player " . $winner . "</strong><br/>";
                  echo "Calc E1 and E2 <br/>";
                  echo "E1 = 1/(1+10^((R2-R1)/400)) <br/>";
                  echo "E2 = 1-E1 <br/>";
                  echo "E1 = " . $E1 . "<br/>";
                  echo "E2 = " . $E2 . "<br/>";
                  echo "R1(new)=R1+160*(W-E1) <br/>";
                  echo "R2(new)=R2+160*(W-E2) <br/>";
                }
                $diff1 = strval(round($R1new - $R1));
                if ($diff1 > 0) {
                  $diff1 = "+" . $diff1;
                }
                $diff2 = strval(round($R2new - $R2));
                if ($diff2 > 0) {
                  $diff2 = "+" . $diff2;
                }
                echo "R1(new) = " . round($R1new) . " (" . $diff1 . ")" . "<br/>";
                echo "R2(new) = " . round($R2new) . " (" . $diff2 . ")" . "<br/>";


                $sql1 = ("UPDATE lolplayers SET elo='$R1new' WHERE id='$player1id'");
                if (mysqli_query($con, $sql1)) {

                } else {
                    echo "Error updating first record: " . mysqli_error($con) . "<br/>";
                }
                $sql2 = ("UPDATE lolplayers SET elo='$R2new' WHERE id='$player2id'");
                if (mysqli_query($con, $sql2)) {

                } else {
                    echo "Error updating second record: " . mysqli_error($con) . "<br/>";
                }
                $savesql = ("INSERT INTO lolmatches (player1id, player2id, winner) VALUES ({$player1id}, {$player2id}, {$winner}) ");
                if (mysqli_query($con, $savesql)) {

                } else {
                    echo "Error updating third record: " . mysqli_error($con) . "<br/>";
                }
              }



            }
  					?>
          </form>
        </div>
        <div class="Footer"></div>
    </div>

</body>
</html>
