<?php
// toggle.php

$gpioPin = 7; 

if (isset($_POST['state']) && $_POST['state'] === 'on') {
    $state = 1;
    $output = shell_exec("sudo gpio write {$gpioPin} 1");
} else {
    $state = 0;
    $output = shell_exec("sudo gpio write {$gpioPin} 0");
}

// Redirect back to the main page
header("Location: clickbutton.php");
exit;
