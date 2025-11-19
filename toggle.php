<?php
// toggle.php

$gpioPin = 7; // BCM 4 = physical pin 7

if (!isset($_POST['state'])) {
    die("No state specified.");
}

$state = $_POST['state'] === 'on' ? '1' : '0';

// Set pin mode to output
shell_exec("sudo gpio mode {$gpioPin} out");

// Write the value (turn LED ON or OFF)
shell_exec("sudo gpio write {$gpioPin} {$state}");

// Redirect back to the main page
header("Location: clickbutton.php");
exit;
?>
