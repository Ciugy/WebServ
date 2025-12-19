<!DOCTYPE html>
<html>
<body>
 
<h1>Information Submitted</h1>
<?php
    include 'dbconnection.php';

    // Make the table
    $sql = "CREATE TABLE IF NOT EXISTS Finals (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(30) NOT NULL,
        last_name VARCHAR(30) NOT NULL,
        IP VARCHAR(45) NOT NULL,
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table Finals created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }


    // Collecting data from form
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

            $stmt = $conn->prepare(
                "INSERT INTO Finals (first_name, last_name, IP)
                VALUES (?, ?, ?)"
            );
            if (!$stmt) {
                echo '<div class="error">Prepare failed: ' . htmlspecialchars($conn->error) . '</div>';
            } else {
                $stmt->bind_param("sss", $first_name, $last_name, $ip_address);

                if (!$stmt->execute()) {
                    echo '<div class="error">Execute failed: ' . htmlspecialchars($stmt->error) . '</div>';
                } else {
                    echo '<div class="success">Thank you! Your information was saved successfully.</div>';
                    echo '<div class="info-list">';
                    echo '<strong>Name:</strong> ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '<br>';
                    echo '<strong>IP Address:</strong> ' . htmlspecialchars($ip_address) . '<br>';
                    echo '</div>';
                }
                $stmt->close();
            }
            $conn->close();

?>

</body>
</html>