<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Information Submitted</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="/CSS/userform.css"/>
    <!-- <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(120deg, #f0f4f8 0%, #e0e7ef 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
            padding: 32px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(60, 60, 90, 0.12);
            text-align: center;
        }
        h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 24px;
        }
        .icon {
            color: #007bff;
            font-size: 2.5rem;
            margin-bottom: 18px;
        }
        .info-list {
            background: #f0f4f8;
            padding: 18px;
            border-radius: 10px;
            color: #34495e;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.08);
            margin-bottom: 16px;
            text-align: left;
            display: inline-block;
        }
        .success {
            color: #27ae60;
            font-weight: bold;
            margin-bottom: 12px;
        }
        .error {
            color: #c0392b;
            font-weight: bold;
            margin-bottom: 12px;
        }
        @media (max-width: 600px) {
            .container {
                padding: 12px;
            }
            h1 {
                font-size: 1.3rem;
            }
        }
    </style> -->
</head>
<body>
    <div class="container">
        <div class="icon">
            <i class="fa fa-check-circle"></i>
        </div>
        <h1>Information Submitted</h1>
        <?php
            include 'dbconnection.php';

            $first_name   = $_POST['name'];
            $last_name    = $_POST['last-name'];
            $email        = $_POST['email'];
            $satisfaction = (int)($_POST['satisfaction'] ?? 0);

            $stmt = $conn->prepare(
                "INSERT INTO Users (first_name, last_name, email, satisfaction)
                VALUES (?, ?, ?, ?)"
            );
            if (!$stmt) {
                echo '<div class="error">Prepare failed: ' . htmlspecialchars($conn->error) . '</div>';
            } else {
                $stmt->bind_param("sssi", $first_name, $last_name, $email, $satisfaction);

                if (!$stmt->execute()) {
                    echo '<div class="error">Execute failed: ' . htmlspecialchars($stmt->error) . '</div>';
                } else {
                    echo '<div class="success">Thank you! Your information was saved successfully.</div>';
                    echo '<div class="info-list">';
                    echo '<strong>Name:</strong> ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '<br>';
                    echo '<strong>Email:</strong> ' . htmlspecialchars($email) . '<br>';
                    echo '<strong>Satisfaction level:</strong> ' . htmlspecialchars($satisfaction) . '<br>';
                    echo '</div>';
                }
                $stmt->close();
            }
            $conn->close();
        ?>
        <p style="color:#888;">We appreciate your feedback!</p>
    </div>
</body>
</html>