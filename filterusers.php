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
                    background-color: #fff0fcff;
                }
            }
        }

    </style>
   
</head>
<body>
    <div class="container">
        <h1>Filter Users</h1>
        <form action="filterusers.php" method="GET">
            <!-- Si tu veux remettre ton oninput... -->
             <!-- utilise le lien suivant pour tester https://www.w3schools.com/tags/tryit.asp?filename=tryhtml5_input_type_button -->
              <!-- aka  <input type="inpuit" value="Click me" onchange="msg(this.value)">-->
                <input type="search" id="searchInput" name="query" placeholder="Search for users..." value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
                <button type="submit">Search</button>
            
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
    <script>
    // EN javascript pure, il faut des events listener pour les inputs
    // sinon ca calisse pas grand chose, ca va call ta function mais ish clair selon la doc 
        const searchInput = document.getElementById("searchInput");
        searchInput.addEventListener("input", (event) => {
            autocomplete(event.target.value);
            // on change => after focus

        });

async function autocomplete(inputEl) {
  const dropdown = document.getElementById("dropdown");
  const query = inputEl.value.trim();

  if (!query) {
    dropdown.innerHTML = "";
    dropdown.style.display = "none";
    return;
  }

  try {
    const response = await fetch(`filterusers.php?query=${encodeURIComponent(query)}`);
    const data = await response.text();

    // ⚠️ Check if your PHP is echoing “Connected successfully”
    // Remove any such echo from dbconnection.php
    console.log("Raw response:", data);

    // Parse the returned HTML
    const parser = new DOMParser();
    const doc = parser.parseFromString(data, "text/html");
    const users = doc.getElementsByClassName("user-result");

    dropdown.innerHTML = ""; // clear previous dropdown content

    if (users.length > 0) {
      for (const user of users) {
        const text = user.innerText.trim();

        const item = document.createElement("div");
        item.classList.add("dropdown-item");
        item.textContent = text;

        // Optional: clicking autofills input
        item.addEventListener("click", () => {
          inputEl.value = text;
          dropdown.style.display = "none";
        });

        dropdown.appendChild(item);
      }
    } else {
      dropdown.innerHTML = "<div class='error'>No users found.</div>";
    }

    dropdown.style.display = "block";
  } catch (err) {
    console.error("Error fetching users:", err);
    dropdown.innerHTML = "<div class='error'>Error loading users.</div>";
    dropdown.style.display = "block";
  }
}


   </script>
</body>
</html>