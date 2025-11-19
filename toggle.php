<?php
// toggle.php

// BCM GPIO number for physical pin 7
$gpioPin = 7;  // pin 7 = BCM 4

if (!isset($_POST['state'])) {
    die("No state specified.");
}

$state = $_POST['state'] === 'on' ? '1' : '0';

// Set pin mode to output
shell_exec("sudo gpio -g mode {$gpioPin} out");

// Write the value
shell_exec("sudo gpio -g write {$gpioPin} {$state}");

// Redirect back to the button page
header("Location: clickbutton.php");
exit;
