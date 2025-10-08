<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Information Submitted</h1>
 

    <?php include 'dbconnection.php'; 
    $satisfaction = $_POST['satisfaction'];
    $stmt = $conn->prepare("INSERT INTO Users (first_name, last_name, email, satisfaction) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $first_name, $last_name, $email, $satisfaction);
    ?>





    <p> 
        Welcome <?= htmlspecialchars($_POST["name"]) . " " . htmlspecialchars($_POST["last-name"]); ?><br>
        Your email address is: <?= htmlspecialchars($_POST["email"]); ?><br>
        Satisfaction level: <?= htmlspecialchars($_POST["satisfaction"]); ?><br>
        POST: <?= var_dump($_POST) ?><br>
    </p>

</body>
</html>