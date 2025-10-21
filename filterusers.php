<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filter Users Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }
        input[type="text"] {
            padding: 8px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            outline: none;
        }
        button {
            padding: 8px 16px;
            font-size: 1em;
            border: none;
            background: #0078d7;
            color: #fff;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        button:hover {
            background: #005fa3;
        }
        .user-result {
            background: #f0f4ff;
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 5px;
            color: #222;
        }
        .error {
            color: #d8000c;
            background: #ffd2d2;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
        }
        .dropdown-list {
            position: relative;
            background: #fff;
            border: 1px solid #ccc;
            max-width: 400px;
            width: 100%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .dropdown-item {
            padding: 8px 12px;
            cursor: pointer;
        }
        .dropdown-item:hover {
            background: #f0f4ff;
        }
        
        .dropdown {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 230px;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;

            a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;

                &:hover {
                    background-color: #f0f4ff;
                }
            }
        }

    </style>
   <script>
       async function autocomplete(query) {
            let filter;
            const dropdown = document.getElementById("dropdown");
            filter = query.toLowerCase();
            if(!query) {
                dropdown.innerHTML = "";
                dropdown.style.display = "none";
                return;
            } else {
                const response = fetch(`filterusers.php?query=${query.value}`)
                .then (response => response.text())
                .then (data => {
                    const parser = new DOMParser();
                    const document_result = parser.parseFromString(data, 'text/html');

                    const users = document_result.getElementsByClassName('user-result');

                    for (user in users) {
                        let text = users[user].innerText;
                        console.log(text, user, 'george');
                        let anchor = document.createElement('a');
                        anchor.innerHTML = text;
                        dropdown.appendChild(anchor);
                    }
                    
                    dropdown.classList.toggle("show");

                });
            } 

            
        };
   </script>
</head>
<body>
    <div class="container">
        <h1>Filter Users</h1>
        <form action="filterusers.php" method="GET">
                <input type="search" id="searchInput" name="query" placeholder="Search for users..." oninput="(value)=>autocomplete(value);" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
                <button type="button">Search</button>
            
            <div id="dropdown" class="dropdown"></div> 
            <br>
        </form>
        <?php
        include 'dbconnection.php';

        if (isset($_GET['query']) && $_GET['query'] !== '') {
            $searchQuery = $_GET['query'];
            $sql = "SELECT * FROM Users WHERE first_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%' OR email LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
            $result = $conn->query(query: $sql);

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
</html>