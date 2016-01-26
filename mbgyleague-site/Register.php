<?php require 'mbgyleague/Connections/Connections.php'?>
<?php

    if(isset($_POST['Register'])) {

        session_start();
        $name = $_POST['Name'];
        $username = $_POST['Username'];
        $email = $_POST['Email'];
        $passwd = $_POST['Password'];


        $emailresult = $con->query("SELECT * FROM user WHERE Email='$email'");
        $userresult = $con->query("SELECT * FROM user WHERE Username='$username'");

        // Check if there is a result when searching for email. If there is a result, the email is already taken.
        if (mysqli_num_rows($emailresult)==0) {
          // Make sure the domain of the email (user@domain.com) is valid.
          list($user, $emaildomain) = explode('@', $email);
          if ($emaildomain == 'skola.malmo.se' || $emaildomain == 'malmo.se') {
            // Check if there is a result when searching for username. If there is a result, the username is already taken.
            if (mysqli_num_rows($userresult)==0) {
              // Make sure password is at least 8 characters
              if (strlen($passwd)>=8){
                // All tests valid, add new user
                $StorePassword = password_hash($passwd, PASSWORD_BCRYPT, array('cost' => 10));

                $sql = $con->query("INSERT INTO user (Name, Username, Email, Password) values ('{$name}', '{$username}', '{$email}', '{$StorePassword}') ");

                header('Location: Login.php');
              } else {
                // Password too short
                $_SESSION["PasswordTooShort"] = "Yes";
              }
            } else {
              // Username taken
              $_SESSION["UsernameInUse"] = "Yes";
            }
          } else {
            // Email domain invalid
            $_SESSION["InvalidEmailDomain"] = "Yes";
          }
        } else {
          // Email taken
          $_SESSION["EmailInUse"] = "Yes";
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
                <?php if(isset($_SESSION["UsernameInUse"])){ ?>
                <div class="FormElement" style="color: red;">There is already an account with that username.</div>
                <?php } ?>

                <div class="FormElement">
                    <input name="Email" type="email" required="Required" class="TField" id="Email" placeholder="School-email">
                </div>
                <?php if(isset($_SESSION["InvalidEmailDomain"])){ ?>
                <div class="FormElement" style="color: red;">You must sign up with a malmö school email.</div>
                <?php } ?>
                <?php if(isset($_SESSION["EmailInUse"])){ ?>
                <div class="FormElement" style="color: red;">There is already an account with that email.</div>
                <?php } ?>

                <?php if(isset($_SESSION["PasswordTooShort"])){ ?>
                <div class="FormElement">Password must be at least 8 characters.</div>
                <?php }?>
                <div class="FormElement" style="color: red;">
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
