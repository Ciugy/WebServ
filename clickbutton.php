
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
        a {
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
$output = shell_exec('gpio read 7');
if (trim($output) == "1") {
    $currentState = "ON"; 
} elseif (trim($output) == "0") {
    $currentState = "OFF";
} else {
    $currentState = "Unknown";
}
?>


<div class="state">Current state: <?php echo htmlspecialchars($currentState); ?></div>


    <a onclick=Toggle() class="on">ON</a>
    <a onclick=Toggle() class="off">OFF</a>

</body>
<script>
    async function Toggle(state) {
        await fetch('toggle.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'state=' + state
        });
        location.reload()
    }
</script>
</html>
