<?php require 'mbgyleague/Connections/Connections.php'?>
<?php

    if(isset($_POST['Register'])) {

        session_start();
        $Name = $_POST['Name'];
        $Username = $_POST['Username'];
        $Email = $_POST['Email'];
        $PW = $_POST['Password'];

        if (strlen($PW)>8){
          list($user, $emaildomain) = explode('@', $Email);
          if ($emaildomain == 'skola.malmo.se' || $emaildomain == 'malmo.se') {
            $StorePassword = password_hash($PW, PASSWORD_BCRYPT, array('cost' => 10));

            $sql = $con->query("INSERT INTO user (Name, Username, Email, Password) values ('{$Name}', '{$Username}', '{$Email}', '{$StorePassword}') ");

            header('Location: Login.php');
          } else {
            $_SESSION["RegisterEmailFail"] = "Yes";
          }
        } else {
          $_SESSION["RegisterPasswordFail"] = "Yes";
        }
    }



?>
<!DOCTYPE html>
<html>
<head>
    <link href="mbgyleague/mbgyleague-css/Menu.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Master.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Register</title>
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
                        <li><a href="Login.php">Log in</a></li>

                    </ul>
                </nav>
            </div>

        </div>
        <div class="LeftBody"></div>
        <div class="RightBody">

            <form action="" method="post" name="RegisterForm" id="RegisterForm">
                <div class="FormElement">
                    <input name="Name" type="text" required="Required" class="TField" id="Name" placeholder="Full Name">
                </div>
                <div class="FormElement">
                    <input name="Username" type="text" required="Required" class="TField" id="Username" placeholder="Username">
                </div>
                <?php if(isset($_SESSION["RegisterEmailFail"])){ ?>
                <div class="FormElement">You must sign up with a malmö school email.</div>
                <?php } ?>
                <div class="FormElement">
                    <input name="Email" type="email" required="Required" class="TField" id="Email" placeholder="School-email">
                </div>

                <?php if(isset($_SESSION["RegisterPasswordFail"])){ ?>
                <div class="FormElement">Password must be at least 8 characters.</div>
                <?php }?>
                <div class="FormElement">
                    <input name="Password" type="password" required="Required" class="TField" id="Password" placeholder="Password">
                </div>
                <div class="FormElement">
                    <input name="Register" type="submit" value="Register" title="Register" id="Register" class="button">
                </div>

            </form>
        </div>
        <div class="Footer">

        </div>
    </div>

</body>
</html>
