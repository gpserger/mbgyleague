<?php require 'mbgyleague/Connections/Connections.php'?>
<?php

    if(isset($_POST['login'])) {

            $Email = $_POST['Email'];
            $PW = $_POST['Password'];

            $result = $con->query("SELECT * FROM user WHERE Email='$Email'");

            $row = $result->fetch_array(MYSQLI_BOTH);

            if(password_verify($PW, $row['Password'])){

            session_start();

            $_SESSION["UserID"] = $row['UserID'];
            $accountphp = 'Location: Account.php?id=' . $row['UserID'];
            header($accountphp);

        }else{
            session_start();
            $_SESSION["LogInFail"] = "Yes";
        }
    }



?>
<!DOCTYPE html>
<html>
<head>
    <link href="mbgyleague/mbgyleague-css/Menu.css" rel="stylesheet" type="text/css">
    <link href="mbgyleague/mbgyleague-css/Master.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Log in</title>
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
                        <li><a href="#">Log in</a></li>

                    </ul>
                </nav>
            </div>

        </div>
        <div class="LeftBody"></div>
        <div class="RightBody">
            <form action="" method="post" name="RegisterForm" id="RegisterForm">
                <?php if(isset($_SESSION["LogInFail"])){ ?>
                <div class="FormElement">Incorrect username or password</div>
                <?php }?>
                <div class="FormElement">
                    <input name="Email" type="text" required="Required" class="TField" id="Email" placeholder="Email">
                </div>
                <div class="FormElement">
                    <input name="Password" type="password" required="Required" class="TField" id="Password" placeholder="Password">
                </div>
                <div class="FormElement">
                    <input name="login" type="submit" required="Required" class="button" id="login" value="Log in">
                </div>
            </form>
        </div>
        <div class="Footer"></div>
    </div>

</body>
</html>
