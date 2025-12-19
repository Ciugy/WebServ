<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Information Submitted</title>
    <link rel="stylesheet" href="../CSS/userform.css">
</head>
<body>
<h1>Information Submitted</h1>
<?php
    include '../PHP/dbconnection.php';

    // Make the table 
    $sql = "CREATE TABLE IF NOT EXISTS Search (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        searchquery VARCHAR(30) NOT NULL,
        IP VARCHAR(45) NOT NULL
    )";

    // Collecting data from form
    if (isset($_POST['search']) && isset($_SERVER['REMOTE_ADDR'])) {
        $search = $_POST['search'];
        $ip_address = $_SERVER['REMOTE_ADDR'];

        $stmt = $conn->prepare(
            "INSERT INTO Search (searchquery, IP)
            VALUES (?, ?)"
        );
        if (!$stmt) {
            echo '<div class="error">Prepare failed: ' . htmlspecialchars($conn->error) . '</div>';
        } else {
            $stmt->bind_param("ss", $search, $ip_address);

            if (!$stmt->execute()) {
                echo '<div class="error">Execute failed: ' . htmlspecialchars($stmt->error) . '</div>';
            } else {
                echo '<div>Google</div>';
                echo '<strong>Search Query:</strong> ' . htmlspecialchars($search) . '<br>';
                echo '<strong>IP Address:</strong> ' . htmlspecialchars($ip_address) . '<br>';
                echo '</div>';
            }
            $stmt->close();
            header("Location: https://www.google.com/search?q=" . urlencode($search));
            exit();
        }
    } else {
        echo '<div class="error">Missing form data.</div>';
    }
    $conn->close();
?>
</body>
</html>