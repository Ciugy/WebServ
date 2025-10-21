<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filter Users Page</title>
    <link rel="stylesheet" href="/CSS/filterusers.css"/>
</head>
<body>
    <div class="container">
        <h1>Filter Users</h1>
        <form action="filterusers.php" method="GET">
                <input autocomplete="off"  type="search" id="searchInput" name="query" placeholder="Search for users..." value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
                <button type="submit">Search</button>
            <br>
        </form>
        <div id="dropdown" class="dropdown"></div> 
        <?php
        include 'dbconnection.php';

        if (isset($_GET['query']) && $_GET['query'] !== '') {
            $searchQuery = $_GET['query'];
            $sql = "SELECT * FROM Users WHERE first_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%' OR email LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='user-result'><strong>Name:</strong> " . htmlspecialchars($row["first_name"]) . " &nbsp; <strong>Email:</strong> " . htmlspecialchars($row["email"]) . "</div>";
                }
            } else {
                echo "<div class='error'>No users found.</div>";
            }
        } else if (isset($_GET['query'])) {
            echo "<div class='error'>No search query provided.</div>";
        }
        ?>
    </div>
</body>
<script src="/JS/filterusers.js"></script>
</html>