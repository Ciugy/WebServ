<?php
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    $gpioPin = 7;
    $output = shell_exec("gpio -g read {$gpioPin}");
    if (trim($output) == "1") {
        echo "ON";
    } elseif (trim($output) == "0") {
        echo "OFF";
    } else {
        echo "Unknown";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raspberry Pi LED Control</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 40px auto;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        .state {
            margin: 10px 0 25px;
            font-weight: bold;
        }
        button {
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            cursor: pointer;
        }
        .on {
            background: #4caf50;
            color: #fff;
            border: none;
        }
        .off {
            background: #f44336;
            color: #fff;
            border: none;
        }
    </style>
</head>
<body>

<h1>LED Control GPIO Pin 7</h1>

<?php
$gpioPin = 7; // BCM pin number
$output = shell_exec("gpio -g read {$gpioPin}");
if (trim($output) == "1") {
    $currentState = "ON";
} elseif (trim($output) == "0") {
    $currentState = "OFF";
} else {
    $currentState = "Unknown";
}
?>

<div class="state" id="ledState">Current state: <?php echo htmlspecialchars($currentState); ?></div>

<button class="on" onclick="toggleLED('on')">Turn ON</button>
<button class="off" onclick="toggleLED('off')">Turn OFF</button>

<script>
function toggleLED(state) {
    fetch('toggle.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'state=' + state
    })
    .then(() => updateState());
}

function updateState() {
    fetch('clickbutton.php?ajax=1')
        .then(response => response.text())
        .then(data => {
            document.getElementById('ledState').textContent = 'Current state: ' + data;
        });
}

// Optionally, poll every few seconds to keep state updated
setInterval(updateState, 3000);
</script>

</body>
</html>
