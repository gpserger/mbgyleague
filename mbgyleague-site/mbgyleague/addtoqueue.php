<?php /*I am writing a matchmaking script for a game through a web portal. For the past few days I have been looking into the different options and I believe the following approach would be the most optimal but I would like the opinion of others.

Get players match requirements through a web form (Method GET) and place the player in queue (mySQL database entry with time stamp and match requirements) for 1 hour.
On the submit page run an ajax script every minute that contacts a php script that checks the following:
Is a player still in the system, if their hour is over or their ajax script has not ran in 5 minutes remove them from the database. Return time out.
Is the player in queue flagged for a match?
If yes then place both players in the in match table and remove both players from queue and send match variables.
If no then continue.
Do the remaining players match the current players requirements?
If yes:
Is the player the same one looking for a match.
If no: Return match variables. Flag other player.
If yes: Return match not found.
If no: Return match not found.
When match variables are received the page will be updated with jquery, including a new ajax request that will call a new php script every 30 seconds to find out if both players accept the match. Possible ajax results are: 0 waiting, 1 accepted, 2 declined. There will also be a button that will send the players response immediately to the php script through ajax that will disable itself through jquery when pushed. When both players accept the page will then use jquery again to display the instructions for beginning the match.
Is there a cleaner or less intensive way to do this with or without involving the database and php?

Notes:
No code is written yet.
The system will not have more than 100 players in queue at any time. (Most likely a peak of 25)*/?>
<?php /* CREATE TABLE `mbgyleague`.`lolmatches` ( `MatchID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `player1id` INT(11) UNSIGNED NOT NULL , `player2id` INT(11) UNSIGNED NOT NULL , `winner` INT(11) UNSIGNED NOT NULL , `played_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`MatchID`)) ENGINE = InnoDB;
         CREATE TABLE `mbgyleague`.`lolmatchqueue` ( `queue_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `searching_player_id` INT(11) UNSIGNED NOT NULL , `elo_requirement` INT(1) UNSIGNED NOT NULL , `elo_min` INT(4) UNSIGNED NOT NULL , `elo_max` INT(4) UNSIGNED NOT NULL , `willing_to_host` INT(1) UNSIGNED NOT NULL DEFAULT '1' , `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`queue_id`)) ENGINE = InnoDB;
         */?>
<?php require 'mbgyleague/Connections/Connections.php' ?>
<!DOCTYPE html>
<html>
<head>
    <link href="mbgyleague/mbgyleague-css/Menu.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Master.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Search for match</title>
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
          <h2 style="font-family: Helvetica;">Search for match</h2>
          <form action"" method="post" name="MatchQueueForm" id="MatchQueueForm">
            <div class="FormElement">
              <input type="radio">
            </div>
        </div>
        <div class="Footer"></div>
    </div>

</body>
</html>
