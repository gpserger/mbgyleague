<?php require 'mbgyleague/Connections/Connections.php' ?>
<!DOCTYPE html>
<html>
<head>
    <link href="mbgyleague/mbgyleague-css/Menu.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Master.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Player rankings</title>
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
        <div class="LeftBody"></div>
        <div class="RightBody">
          <?php

            $result = mysqli_query($con,"SELECT * FROM lolplayers;");

            echo "<table border='1'>
            <tr>
            <th>id</th>
            <th>elo</th>
            </tr>";

            while($row = mysqli_fetch_array($result))
            {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['elo'] . "</td>";
            echo "</tr>";
            }
            echo "</table>";

            mysqli_close($con);
            ?>
        </div>
        <div class="Footer"></div>
    </div>

</body>
</html>
