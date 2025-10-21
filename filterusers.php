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
    <script>
        // const searchInput = document.getElementById("searchInput");
        // searchInput.addEventListener("input", (event) => {
        //     autocomplete(event.target.value);

        // });


        // async function autocomplete(query) {
        //     const dropdown = document.getElementById("dropdown");
        //     if(!query) {
        //         dropdown.innerHTML = "";
        //         dropdown.style.display = "none";
        //         return;
        //     }

        //     dropdown.innerHTML = "";

        //             fetch("filterusers.php?query=" + encodeURIComponent(query), {
        //             headers: { "X-Requested-With": "XMLHttpRequest" }
        //         })
        //         .then (response => response.text())
        //         .then (data => {
        //             console.log(data, 'data');
        //             const parser = new DOMParser();
        //             const document_result = parser.parseFromString(data, 'text/html');
        //             const users = document_result.getElementsByClassName('user-result');
        //             console.log(users, 'users');

        //             if (users.length === 0) {
        //                 dropdown.style.display = "none";
        //                 return;
        //             }

        //             // Inspiration https://codepen.io/jaredgroff/pen/bGxJaXe
        //             Array.from(users).forEach(userElem => {
        //                 let text = userElem.innerText;
        //                 let anchor = document.createElement('a');
        //                 anchor.textContent = text;
        //                 anchor.classList.add('dropdown-item');
        //                 anchor.onclick = () => {
        //                     searchInput.value = userElem.querySelector('strong').nextSibling.textContent.trim();
        //                     dropdown.style.display = "none";
        //                 };
        //                 dropdown.appendChild(anchor);
        //             });
                    
        //             dropdown.style.display = "block";

        //         });
        // };

   </script>
</body>
<script src="/JS/filterusers.js"></script>
</html>