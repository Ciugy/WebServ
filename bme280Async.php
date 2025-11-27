

<?php
// file: api_bme280.php

header('Content-Type: application/json');

$raw = shell_exec('./bm280');   // same as before

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

exit;

