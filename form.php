<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Who are you?</h1>
 
    <p> 
        Welcome <?php echo $_GET["name"] . " " . $_GET["last-name"]; ?><br>
        Your email address is: <?php echo $_GET["email"]; ?>
        GET: <?= var_dump($_GET) ?><br>
        POST: <?= var_dump($_POST) ?>

    </p>

</body>
</html>