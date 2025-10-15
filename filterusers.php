<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filter users page</title>
</head>
<body>    

    <form action="filterusers.php" method="GET">
        <input type="text" name="query" placeholder="Search for users...">
        <button type="submit">Search</button>
    </form>
    <?php
    include 'dbconnection.php';

    if (isset($_GET['query']) && $_GET['query'] !== '') {
        $searchQuery = $_GET['query'];
        $sql = "SELECT * FROM Users WHERE first_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%' OR email LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Username: " . htmlspecialchars($row["first_name"]) . " - Email: " . htmlspecialchars($row["email"]) . "<br>";
            }
        } else {
            echo "<div class='container'><p class='error'>No users found.</p></div>";
        }
    } else {
        echo "<div class='container'><p class='error'>No search query provided.</p></div>";
    }
    ?>
</body>
</html>