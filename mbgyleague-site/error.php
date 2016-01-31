<?php require 'mbgyleague/Connections/Connections.php' ?>
<!DOCTYPE html>
<html>
<head>
    <!-- <link href="mbgyleague/mbgyleague-css/Menu.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Master.css" rel="stylesheet" type="text/css"> -->
    <meta charset="utf-8">
    <title>Error</title>
</head>

<body>
    <h2>Error:</h2>
    <div class="Container">
      <?php if(isset($_GET["code"])) { ?>
        <?php if($_GET["code"] == "1") { ?>
          <div> Insufficient permission. <div>
        <?php } elseif ($_GET["code"] == "2") {?>
          <div> </div>
        <?php } else { echo "Unknown error."; }?>
      <?php } else {?>
        <div>Unknown error.</div>
      <?php } ?>
    </div>

</body>
</html>
