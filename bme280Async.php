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
// file: api_bme280.php

header('Content-Type: application/json');

$raw = shell_exec('./bme280');   // same as before

if ($raw === null || $raw === '') {
    echo json_encode(['error' => 'No data from bme280']);
    exit;
}

$data = json_decode($raw, true);

if ($data === null) {
    echo json_encode(['error' => 'JSON decode failed', 'raw' => $raw]);
    exit;
}

echo json_encode($data);

?>

<h1>BME280 Sensor Readings</h1>

<button id="refreshBtn">Get Current Readings</button>

<div id="reading">
  <p><strong>Sensor:</strong> <span id="sensor"></span></p>
  <p><strong>Temperature:</strong> <span id="temperature"></span></p>
  <p><strong>Humidity:</strong> <span id="humidity"></span></p>
  <p><strong>Pressure:</strong> <span id="pressure"></span></p>
  <p><strong>Altitude:</strong> <span id="altitude"></span></p>
  <p><strong>Timestamp:</strong> <span id="timestamp"></span></p>
  <p id="error" style="color:red;"></p>
</div>

<script>
async function loadReading() {
  document.getElementById('error').textContent = '';

  try {
    const res = await fetch('api_bme280.php'); // AJAX / async request
    const data = await res.json();

    if (data.error) {
      document.getElementById('error').textContent = data.error;
      return;
    }

    document.getElementById('sensor').textContent     = data.sensor;
    document.getElementById('temperature').textContent = data.temperature + ' °C';
    document.getElementById('humidity').textContent    = data.humidity + ' %';
    document.getElementById('pressure').textContent    = data.pressure + ' hPa';
    document.getElementById('altitude').textContent    = data.altitude + ' m';
    document.getElementById('timestamp').textContent   = data.timestamp;
  } catch (err) {
    document.getElementById('error').textContent = 'Request failed: ' + err;
  }
}

// button click = async JS call, no page reload
document.getElementById('refreshBtn').addEventListener('click', loadReading);

// optional: auto-refresh every 5 seconds
// setInterval(loadReading, 5000);
</script>


</body>
</html>
