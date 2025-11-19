<?php
// toggle.php

$gpioPin = 4; 

if (!isset($_POST['state'])) {
    die("No state specified.");
}

$state = $_POST['state'] === 'on' ? '1' : '0';

// Set pin mode to output
shell_exec("sudo gpio -g mode {$gpioPin} out");

// Write the value (turn LED ON or OFF)
shell_exec("sudo gpio -g write {$gpioPin} {$state}");


exit;
