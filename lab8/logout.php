<?php
session_start();

$_SESSION['loggedin'] = false;
$_SESSION['loggedinA'] = false;

session_destroy();

header("Location: signin.html");
exit();
?>
