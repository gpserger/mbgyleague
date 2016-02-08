<?php require 'mbgyleague/Connections/Connections.php' ?>
<?php // $id=$_GET["id"];?>
<?php
    session_start();
    if(isset($_GET["id"])){
      $id=$_GET["id"];
    } elseif (isset($_SESSION["UserID"])) {
      $id=$_SESSION["UserID"];
    } else {
      header('Location: Login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link href="mbgyleague/mbgyleague-css/Menu.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Master.css" rel="stylesheet" type="text/css">
    <style>
      table { font-family: Arial, Helvetica, sans-serif; }
      .odd {background-color: lightgray;}
      .even {background-color: white;}
      td {
        padding: 7px;
        padding-bottom: 7px;
        padding-right: 20px;
        padding-left: 15px;
      }
      .title {font-weight: bold; padding-right: 30px;}
      td:last-child {font-style: italic;}
    </style>
    <meta charset="utf-8">
    <title>Account</title>
</head>

<body>
    <div class="Container">
        <div class="Header">
        </div>
        <div class="menu">
            <div id="Menu">
                <nav>
                    <ul class="cssmenu">

                        <li><a href="Register.php">Register</a></li>
                        <li><a href="Login.php">Log in</a></li>

                    </ul>
                </nav>
            </div>

        </div>
        <div class="LeftBody">

        </div>
        <div class="RightBody">
          <?php if ($id==$_SESSION['UserID']) {?>
            <div>
              This is your account.<br/><br/>
              <a href="Logout.php" class="button" style="padding: 10px;margin-top:;">Log out</a>
            </div>
          <?php } ?>
          <?php
            $result = mysqli_query($con,"SELECT Name, Username, Userlevel FROM `user` WHERE UserID = $id;");
            if(mysqli_num_rows($result)!=0){
              echo "<h3 style='font-family: Helvetica;'>About:</h3>";
              $elo_result = mysqli_query($con,"SELECT elo FROM `lolplayers` WHERE id = $id;");
              $row = mysqli_fetch_array($result);
              $elo = mysqli_fetch_array($elo_result);

              if($row['Userlevel'] >= 10) {
                $accountlevel = $row['Userlevel'] . " (Admin)";
              } else {
                $accountlevel = $row['Userlevel'];
              }

              echo "<table cellspacing='0'>";

                echo "<tr class='odd'>";
                  echo "<td class='title'><strong>Name</strong></td>";
                  echo "<td>" . $row['Name'] . "</td>";
                echo "</tr>";

                echo "<tr class='even'>";
                  echo "<td class='title'>Username</td>";
                  echo "<td>" . $row['Username'] . "</td>";
                echo "</tr>";

                echo "<tr class='odd'>";
                  echo "<td class='title'>Rating</td>";
                  echo "<td>" . $elo['elo'] . "</td>";
                echo "</tr>";

                echo "<tr class='even'>";
                  echo "<td class='title'>Account level</td>";
                  echo "<td>" . $accountlevel . "</td>";
                echo "</tr>";

                echo "<tr class='odd'>";
                  echo "<td class='title'>ID</td>";
                  echo "<td>" . $id . "</td>";
                echo "</tr>";

              echo "</table>";
              echo "<h3 style='font-family: Helvetica;'>Recent matches:</h3>";
              $recentmatchesresult = mysqli_query($con, "SELECT * FROM `lolmatches` WHERE player1id = $id OR player2id = $id ORDER BY `MatchID` DESC LIMIT 5;");
              $lastmatchresult = mysqli_query($con, "SELECT `MatchID` FROM `lolmatches` WHERE player1id = $id OR player2ID = $id ORDER BY `MatchID` DESC LIMIT 1;");

              $lastmatchid = mysqli_fetch_field($lastmatchresult);

                if(mysqli_num_rows($recentmatchesresult)!=0){
                  echo "<table cellspacing='0'>";

                    echo "<tr class='even'>";
                      echo "<td class='title'><strong>vs.</strong></td>";
                      echo "<td class='title'><strong>Result</strong></td>";
                      echo "<td class='title'><strong>played_date</strong></td>";
                    echo "</tr>";

                  $rowclass="odd";
                  while ($matchrow = mysqli_fetch_array($recentmatchesresult)) {
                    if ($rowclass=="even") {
                      echo "<tr class='even'>";
                      $rowclass="odd";
                    } else {
                      echo "<tr class='odd'>";
                      $rowclass="even";
                    }
                      if ($matchrow['player1id']==$id) {
                        $opponentlink=$matchrow['player2id'];
                        echo "<td><a href='Account.php?id=$opponentlink'>" . $matchrow['player2id'] . "</a></td>";
                      } else {
                        $opponentlink=$matchrow['player1id'];
                        echo "<td><a href='Account.php?id=$opponentlink'>" . $matchrow['player1id'] . "</a></td>";
                      }
                      if ($matchrow['winner']==$id) {
                        echo "<td><strong style='color: green;'>Win</strong></td>";
                      } else {
                        echo "<td><strong style='color: red;'>Loss</strong></td>";
                      }
                      /*echo "<td>" . $matchrow['player1id'] . "</td>";
                      echo "<td>" . $matchrow['player2id'] . "</td>";
                      echo "<td>" . $matchrow['winner'] . "</td>";*/
                      echo "<td>" . substr($matchrow['played_date'], 0, strpos($matchrow['played_date'], " ")) . "</td>";
                    echo "</tr>";
                  }
                  echo "</table>";
                } else {
                  echo "<p>No matches to display</p>";
                }
              } else {
                echo "<p>No account with this ID</p>";
              }
              mysqli_close($con);
          ?>
        </div>
        <div class="Footer"></div>
    </div>

</body>
</html>
