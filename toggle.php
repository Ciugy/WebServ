<?php
// toggle.php

$gpioPin = 7; 

if ($state = $_POST['state'] === 'on') {
    $state = '1';
} else {
    $state = '0';
}


// Set pin mode to output
shell_exec("sudo gpio mode {$gpioPin} out");

// Write the value (turn LED ON or OFF)s
shell_exec("sudo gpio write {$gpioPin} {$state}");


// Redirect back to the main page
header("Location: clickbutton.php");
exit;
