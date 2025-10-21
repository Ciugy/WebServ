<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Information Submitted</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="/CSS/userform.css"/>
</head>
<body>
    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="about.html">About us</a>
        <div class="dropdown" tabindex="0">
          <button class="dropbtn" aria-haspopup="true" aria-expanded="false">
            Types of cars <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content" aria-label="submenu">
            <a href="sedans.html">Sedans</a>
            <a href="#">SUVs</a>
            <a href="#">Bikes</a>
          </div>
        </div>
    </div>
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