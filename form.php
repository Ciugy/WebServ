<!DOCTYPE html>
<html lang="en">
<body>
    <h1>User Agent</h1>
 
        <?php
        Welcome echo $_GET["name"]; echo $_GET["last-name"];
        Your email address is: <?php echo $_GET["email"]; 
        ?>

        <p>GET: <?= var_dump($_GET) ?></p>
        <p>POST: <?= var_dump($_POST) ?></p>

</body>
</html>