<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Information Submitted</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="./CSS/userform.css" />
    <style>
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
    </style>
</head>
<body>    

    <form action="filterusers.php" method="GET">
        <input type="text" name="query" placeholder="Search for users...">
        <button type="submit">Search</button>
    </form>
    <?php
    include 'dbconnect.php';
    if (isset($_GET['query'])) {
        $searchQuery = $_GET['query'];
    }

    
    $sql = "SELECT * FROM users WHERE username LIKE '%" . $conn->real_escape_string($searchQuery) . "%' OR email LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Username: " . $row["username"]. " - Email: " . $row["email"]. "<br>";
        }
    } else {
        echo "<div class='container'><p class='error'>No search query provided.</p></div>";
    }
    ?>
    </div>
</body>
</html>