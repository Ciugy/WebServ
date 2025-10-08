<!DOCTYPE html>
<html lang="en">
<body>
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
        if (!$stmt) die("Prepare failed: " . $conn->error);

        $stmt->bind_param("sssi", $first_name, $last_name, $email, $satisfaction);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        echo "Inserted OK. Rows: " . $stmt->affected_rows;
        $stmt->close();
        $conn->close();

    ?>





    <p> 
        Welcome <?= htmlspecialchars($_POST["name"]) . " " . htmlspecialchars($_POST["last-name"]); ?><br>
        Your email address is: <?= htmlspecialchars($_POST["email"]); ?><br>
        Satisfaction level: <?= htmlspecialchars($_POST["satisfaction"]); ?><br>
        POST: <?= var_dump($_POST) ?><br>
    </p>

</body>
</html>