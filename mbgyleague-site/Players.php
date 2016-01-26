<?php require 'mbgyleague/Connections/Connections.php' ?>
<!DOCTYPE html>
<html>
<head>
    <link href="mbgyleague/mbgyleague-css/Menu.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Master.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Table.css" rel="stylesheet" type="text/css">
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
        <!--<div class="LeftBody"></div>-->
        <div class="RightBody">
          <?php

            $result = mysqli_query($con,"SELECT Name, elo FROM `user` INNER JOIN lolplayers ON UserID = id ORDER BY elo DESC;");

            echo "<table cellspacing='0'>
            <tr>
            <th>Placing</th>
            <th>Name</th>
            <th>Rating</th>
            </tr>";
            $rowcount = 1;
            while($row = mysqli_fetch_array($result))
            {
            echo "<tr>";
            echo "<td>$rowcount</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['elo'] . "</td>";
            echo "</tr>";
            $rowcount++;
            }
            echo "</table>";

            mysqli_close($con);
            ?>
        </div>
        <?php /* <table cellspacing='0'> <!-- cellspacing='0' is important, must stay -->

        	<!-- Table Header -->
        	<thead>
        		<tr>
        			<th>Task Details</th>
        			<th>Progress</th>
        			<th>Vital Task</th>
        		</tr>
        	</thead>
        	<!-- Table Header -->

        	<!-- Table Body -->
        	<tbody>

        		<tr>
        			<td>Create pretty table design</td>
        			<td>100%</td>
        			<td>Yes</td>
        		</tr><!-- Table Row -->

        		<tr class="even">
        			<td>Take the dog for a walk</td>
        			<td>100%</td>
        			<td>Yes</td>
        		</tr><!-- Darker Table Row -->

        		<tr>
        			<td>Waste half the day on Twitter</td>
        			<td>20%</td>
        			<td>No</td>
        		</tr>

        		<tr class="even">
        			<td>Feel inferior after viewing Dribble</td>
        			<td>80%</td>
        			<td>No</td>
        		</tr>

        		<tr>
        			<td>Wince at "to do" list</td>
        			<td>100%</td>
        			<td>Yes</td>
        		</tr>

        		<tr class="even">
        			<td>Vow to complete personal project</td>
        			<td>23%</td>
        			<td>yes</td>
        		</tr>

        		<tr>
        			<td>Procrastinate</td>
        			<td>80%</td>
        			<td>No</td>
        		</tr>

        		<tr class="even">
        			<td><a href="#yep-iit-doesnt-exist">Hyperlink 	Example</a></td>
        			<td>80%</td>
        			<td><a href="#inexistent-id">Another</a></td>
        		</tr>

        	</tbody>
        	<!-- Table Body -->

        </table> */ ?>
        <div class="Footer"></div>
    </div>

</body>
</html>
