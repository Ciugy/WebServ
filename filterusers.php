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
        .search-wrapper {
        position: relative;
        width: 100%;
        }

        .dropdown-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        max-height: 250px;
        overflow-y: auto;
        z-index: 100;
        display: none;
        }

        .dropdown-item {
        padding: 8px 12px;
        cursor: pointer;
        color: #222;
        text-decoration: none;
        display: block;
        }

        .dropdown-item:hover {
        background: #f0f4ff;
        }

    </style>
   
</head>
<body>
    <div class="container">
        <h1>Filter Users</h1>
        <form action="filterusers.php" method="GET">
            <div class="search-wrapper">
                <input
                autocomplete="off"
                type="search"
                id="searchInput"
                name="query"
                placeholder="Search for users..."
                oninput="autocomplete(this)"
                value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>"
                >
                <div id="dropdown" class="dropdown-list"></div>
            </div>
            <button type="submit">Search</button>
            <br>
        </form>
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
    <script>
    // EN javascript pure, il faut des events listener pour les inputs
    // sinon ca calisse pas grand chose, ca va call ta function mais ish clair selon la doc 
        const searchInput = document.getElementById("searchInput");
        searchInput.addEventListener("input", (event) => {
            autocomplete(event.target.value);

        });


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
                    // TODO : Fix le fetch de la page, ca retourne un html avec ERROR no user found
                    // regarde le HTML que ca te donne tu vas voir des truc biz biz, du genre
                    //  Connected successfully<div class='error'>No users found.</div>    </div>
                    // Il si tu fixes ca, tu devrais avoir something
                    console.log(data, 'data');
                    const parser = new DOMParser();
                    const document_result = parser.parseFromString(data, 'text/html');

                    const users = document_result.getElementsByClassName('user-result');
                    console.log(users, 'users');

                    for (const user of users) {
                    const text = user.innerText.trim();
                    console.log(text, user, 'george');

                    const anchor = document.createElement('a');
                    anchor.textContent = text; // safer than innerHTML
                    anchor.classList.add('dropdown-item');

                    // optional: make each dropdown item clickable
                    anchor.addEventListener('click', () => {
                        document.getElementById('searchInput').value = text;
                        dropdown.style.display = 'none';
                    });

                    dropdown.appendChild(anchor);
                    }
                    
                    dropdown.style.display = "block";

                });
            } 
        };

   </script>
</body>
</html>