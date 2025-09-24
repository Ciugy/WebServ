<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Who are you?</h1>
 
    <p> 
        Welcome <?= htmlspecialchars($_POST["name"]) . " " . htmlspecialchars($_POST["last-name"]); ?><br>
        Your email address is: <?= htmlspecialchars($_POST["email"]); ?><br>
        GET: <?= var_dump($_GET) ?><br>
        POST: <?= var_dump($_POST) ?><br>
    </p>

</body>
</html>