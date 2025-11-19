<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BME280 Sensor Readings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        .reading {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            display: inline-block;
            text-align: left;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>BME280 Sensor Readings</h1>

<form method="post">
    <button type="submit">Get Current Readings</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Run the bme280 executable in the same directory
    $raw = shell_exec('./bm280');

    if ($raw === null || $raw === '') {
        echo "<p><strong>Error:</strong> No data received from bme280.</p>";
    } else {
        // Decode JSON
        $data = json_decode($raw, true);

        if ($data === null) {
            echo "<p><strong>Error:</strong> Could not decode JSON:<br>" . htmlspecialchars($raw) . "</p>";
        } else {
            $sensor      = $data['sensor']      ?? 'unknown';
            $humidity    = $data['humidity']    ?? 'n/a';
            $pressure    = $data['pressure']    ?? 'n/a';
            $temperature = $data['temperature'] ?? 'n/a';
            $altitude    = $data['altitude']    ?? 'n/a';
            $timestamp   = $data['timestamp']   ?? 'n/a';

            // Readings display
            echo '<div class="reading">';
            echo '<strong>Sensor:</strong> '      . htmlspecialchars($sensor)      . '<br>';
            echo '<strong>Temperature:</strong> ' . htmlspecialchars($temperature) . " °C<br>";
            echo '<strong>Humidity:</strong> '    . htmlspecialchars($humidity)    . " %<br>";
            echo '<strong>Pressure:</strong> '    . htmlspecialchars($pressure)    . " hPa<br>";
            echo '<strong>Altitude:</strong> '    . htmlspecialchars($altitude)    . " m<br>";
            echo '<strong>Timestamp:</strong> '   . htmlspecialchars($timestamp)   . '<br>';
            echo '</div>';
        }
    }
}
?>

</body>
</html>
