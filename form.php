<!DOCTYPE html>
<html lang="en">
<body>
    <h1>User Agent</h1>
 
    <p> 
        <?php
        echo "Welcome " $_GET["name"] . "" . $_GET["last-name"] . "<br>";
        echo "Your email address is: "  . $_GET["email"] . "<br>";
        var_dump($_GET); 
        var_dump($_POST);
        ?>
    </p>

</body>
</html>