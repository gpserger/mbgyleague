<?php

$email = "utbgusser@skola.malmo.se";
echo "Email: " . $email . "<br/>";

list($user, $domain) = explode('@', $email);

if ($domain == 'skola.malmo.se' || $domain == 'malmo.se') {
  echo "domain is valid";
} else {
  echo "domain is invalid";
}
// if $email is toto@gmail.com then $user is toto

 ?>
